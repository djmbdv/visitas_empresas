<?php


require_once "core/Controller.php";
require_once "config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
/**
 * 
 */
class FotoController extends ControllerRest
{

	public function post($argument= null){
		$user = UserModel::user_logged();
		if(is_null($user)){
			header('location: /login/');
			return;
		}
		$id = $_POST['document_id'];
		$section  = $_POST['section'];
		$visitado = $_POST['visitado'];
		$name = $_POST['name'];
		$vista = new FotoView(array('id'=>$id,'user'=>$user,'section'=>$section,'visitado'=>$visitado,'name'=>$name ));
		return $vista->render();
	}

	public function any($argument = null){
		header('location: /');
	}

	public function visita($argument = null){
		$user = UserModel::user_logged();
		if(is_null($user)){
			header('location: /login/');
			return;
		}
		$id = $_POST['document_id'];
		$section  = $_POST['section'];
		$visitado = $_POST['visitado'];
		$vis = new EmployeeModel();
		$vis->ID = $visitado; 
		$name = $_POST['name'];
		$photo = $_POST['photo'];
		$visita  = new VisitaModel();
		$visita->name = $name;
		$visita->document_id = $id;
		$a = new SectionModel();
		$a->ID = $section;
		$visita->destino= $a;

		$visita->photo = $photo;
		$photo = explode(',',$photo ?? "")[1];
		$photo = base64_decode($photo ?? "");
        $link = "/_static/photos/".uniqid();
        $ext = ".png";
		
		$filename = Config::$base_folder. $link.$ext;
		$ifp = fopen(  $filename, 'wb' ); 
		
		fwrite($ifp,$photo);
		fclose($ifp);
		$vis->load();
		list($ancho, $alto) = getimagesize($filename);
		$origen = imagecreatefrompng($filename);
		$thumb = imagecreatetruecolor(400,(400/$ancho)*$alto);
		unlink($filename);
		$ext = ".jpg";
		$filename = Config::$base_folder. $link.$ext;
		
		imagecopyresized($thumb, $origen, 0, 0, 0, 0, 400, (400/$ancho)*$alto, $ancho, $alto);
		imagejpeg($thumb,$filename);
		$visita->visitado = $vis;
		$visita->cliente = $user;
		$user->load();
		$visita->photo = Config::$base_url.$link.$ext;
		$visita->save();
		$mail = new PHPMailer(true);
		/*try {
		    //Server settings
		//    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
		    $mail->isSMTP();                                           
		    $mail->Host       = Config::$mail_host;                   
		    $mail->SMTPAuth   = true;                                  
		    $mail->Username   = Config::$mail_username;                    
		    $mail->Password   = Config::$mail_password;                            
	//	    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          
		    $mail->Port       = Config::$mail_port;                                 
		    $mail->setFrom('asistencia@remotepcsolutions.com', 'Control de Visitas');
		    $mail->addAddress($vis->email, $vis->name);     //Add a recipient
	
			$mail->addAttachment($vis->photo, 'photo.jpg');    //Optional name

		    //Content
		    $mail->isHTML(true);                                  //Set email format to HTML
		    $mail->Subject = 'Nueva Visita';
		    $mail->Body    = "<h1>Sistema de control de visitas</h1>"
		    ."<h2>{$user->titulo}</h2>"
		    .'<h3>Tiene una nueva visita<h3>'
		    ."<p> Nombre: {$visita->name}"
		    ."<p> Identificación: {$visita->document_id}";
		 //   $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		    $mail->send();
		  //  echo 'Message has been sent';
		} catch (Exception $e) {
		    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}*/
		 header('location: /saludo');
	}
}