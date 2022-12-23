function _getUserMedia(){
	return (navigator.getUserMedia || (navigator.mozGetUserMedia ||  navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia).apply(navigator, arguments);
}
function tieneSoporteUserMedia(){
	return !!(navigator.getUserMedia || (navigator.mozGetUserMedia ||  navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia)
}

function active_camera(){
	if (tieneSoporteUserMedia()) {
	    _getUserMedia(
	        {video: true},
	        function (stream) {
	        	var video = document.getElementById("video");
				video.srcObject  = (stream);
				video.play()
	        	$('.info-foto').text("Presione \"Tomar Foto\"");
	        	$('.button-photo').prop('disabled', false);
	        }, function (error) {
	            alert("Permiso denegado o error: ", error);
	        });
	} else {
	    alert("El navegador no soporta esta característica");
	}
}

if( document.getElementsByClassName('modal').length == 0 &&  document.getElementsByTagName('video').length > 0 ) $('video').ready(active_camera);
	$('.button-photo').click(()=>{
			var text = $('.info-foto').text();
			if(text == "Listo"){
						active_camera();
						$('.info-foto').text("Presione \"Tomar Foto\"")
						$('.button-photo').text("Tomar Foto")
						return;
					}
			var t = setInterval(()=>{
					var text = $('.info-foto').text();
					var estilos =  $('.info-foto').css(["font-size"])
					if(isNaN(text)){
						$('.info-foto').text(3);
						$('.info-foto').css("font-size","18px")
					}else {
						text-=1;
						if(text > 0){
						//	alert(text);
							$('.info-foto').text(text)
						}else{
							document.getElementById("captura").classList.add('marco-foto')
							setTimeout(
								function() {
									document.getElementById("captura").classList.remove('marco-foto')
								}, 1
							);
							var video = document.getElementById("video")
							var canvas = document.getElementById("canvas")
							var mediaStream = video.srcObject;
							var tracks = mediaStream.getTracks();
							video.pause();

							tracks.forEach(track => track.stop())
							$('.info-foto').text("Listo")
							$('.button-photo').text("Tomar nueva foto")
							$(".btn-form-foto").prop("disabled",false)
							var contexto = canvas.getContext("2d");
							canvas.width = video.videoWidth;
    						canvas.height = video.videoHeight;
    						contexto.drawImage(video, 0, 0, canvas.width, canvas.height);
    						
    						$("#inputFoto").val(canvas.toDataURL())
    						 $('.info-foto').css(estilos)
							clearInterval(t);
						}
					}
				}
				, 1010);
	}
)


$(".save-modal").click(
	() =>{
		f = $("#form-modal").serialize();
		$.ajax({
	  url: $("#form-modal").attr("action"),
	  type: $("#form-modal").attr("method"),
	  data: f,
	  success: function(data) {
	  	console.log(data)
	   	if(data.ok) location.reload();
	   	else alert(data.errorMsj)
	  }
	})
});

function desactive_camera(){
	var video = document.getElementById("video")
	var canvas = document.getElementById("canvas")
	var mediaStream = video.srcObject;
	var tracks = mediaStream.getTracks();
	video.pause();
	tracks.forEach(track => track.stop())
}

$(".btn-add").click(e=>{
	$("#form-modal").attr("method","post");
	$(".key-input").remove();
})

$(".btn-delete").click(e=>{
	$(".btn-aceptar").data({method: "delete",key: $(e.currentTarget).data("key"),model: $(e.currentTarget).data("model")})
	$("#askModal").modal("show");
})

$(".btn-aceptar").click(e=>{
	var a = $(e.currentTarget).data() ;
		$.ajax({
	  url: "./key=" +a.key,
	  type: a.method,
	  success: function(data) {
	  	console.log(data)
	   	if(data.ok) location.reload();
	   	else alert(data.errorMsj)
	  }
	})  
})



$(".btn-view").click(e=>{
	var a = $(e.currentTarget).data();
	$.post("/api/" + a.model, a).done(
		data=>{
			Object.keys(data).forEach(a =>{
				if(typeof(data[a]) == 'object' && data[a] != null ){
					var element = "#inputv"+a.charAt(0).toUpperCase()+a.slice(1);
					if($(element).is("select")){
					  $(element).val(data[a].ID)
					  return
					}
					$(element+'1').val(data[a].ID);
					$.post("/api/" + $(element).data('clase'),
					{ 'key' : $("#"+$(element).attr("entrada")).val() },
					kk => {
						$(element).val(kk.presentation);
						$(element).addClass('input-success');
					});

				}
				else {
					$("#inputv"+a.charAt(0).toUpperCase()+a.slice(1)).attr("type") == "file"?
					$("#inputv"+a.charAt(0).toUpperCase()+a.slice(1)+'1').val(data[a]) :
					$("#inputv"+a.charAt(0).toUpperCase()+a.slice(1)).val(data[a]);

				}
			});
			$(".image-buffer").each((i,u)=>{
				$(u).attr('src',$('#'+$(u).attr('fuente')).val());
			});
			$('#viewModal').modal('show');
		})
})
$(".btn-pin-modal").click(e=>{
	$("#pinModal").modal("show")
})
$(".btn-edit").click(e=>{
	var a = $(e.currentTarget).data();
//	console.log(a);
	$.post("/api/"+a.model, a).done(
		data=>{
			Object.keys(data).forEach(a =>{
				if(a == "password")return;
				if(typeof(data[a]) == 'object' &&  data[a] != null){
					console.log(data[a]);
					var element = "#input"+a.charAt(0).toUpperCase()+a.slice(1);
					if($(element).is("select")){
					  $(element).val(data[a].ID)
					  return
					}
					$(element+'1').val(data[a].ID);
					$.post("/api/" + $(element).data('clase'),
					{ 'key' : $("#"+$(element).attr("entrada")).val() },
					kk => {
						$(element).val(kk.presentation);
						$(element).addClass('input-success');
					});

				}
				else {
					$("#input"+a.charAt(0).toUpperCase()+a.slice(1)).attr("type") == "file"?
					$("#input"+a.charAt(0).toUpperCase()+a.slice(1)+'1').val(data[a]) :
					$("#input"+a.charAt(0).toUpperCase()+a.slice(1)).val(data[a]);

				}

			});
			
			$("#form-modal").attr("method","put")
			$(".key-input").remove()
			var input = document.createElement('input')
			input.type = "hidden"
			input.name = "key"
			input.class = "key-input"
			input.value = a.key;
			$("#form-modal").append(input)
			$('#formModal').modal('show');
		}
	);
});

$(".btn-download").click(e=>{
	e.preventDefault();
//alert("hola")
	str = "$desde="+$("#inputDesde").val();
	str+="$hasta="+$("#inputHasta").val();
	window.location = "/dashboard/reporte/"+str;
})
$(".modal-camara").on('shown.bs.modal', function(){
    active_camera();
  });
$(".modal-camara").on('hide.bs.modal', function(){
    desactive_camera();
  });

$("#formModal").on('reset', function(){
    $("input").removeClass("input-success");
  });
$("#formModal").on('hide.bs.modal', function(){
    document.getElementById("form-modal").reset();
  });


function loadSelect(b){
	$.post(b.getAttribute("end_point"),$(b).data(),data=>{
		$(b).children().each((a,k)=>{if(a>0)k.remove();else k.selected = true})

		for(i = 1; i < b.children.length; i++)b.removeChild(b.children[1])
		data.forEach(a =>{
		op = document.createElement("option")
		b.appendChild(op)
		op.value =  a.id
		op.innerText = a.presentation
		})
		b.disabled=false;
	}
	)
}

$("select").each((a,b)=>{
	if(b.getAttribute("autoload") == "true") 
	loadSelect(b)
})

function get_params(){
	k = document.location.href.split('/').slice(-1)[0]
	o =  new Object
	if(k.length > 0){
		valores = k.split('$')
		valores.forEach(e =>{
			ll = e.split('=')
			o[ll[0]] = ll[1]
		})
	}
	return o;
}

$(".form-filter").submit(e=>{
	e.preventDefault()
	console.log(e.currentTarget)
	url = "";
	o = get_params();
	e.currentTarget.querySelectorAll( "input, select, textarea" ).forEach(
		e=>{ 
			if(e.name==null || e.value == null)return
			o[e.name] = e.value
		})
	Object.entries(o).forEach(e=>{
		url+='$' + e[0]+'='+e[1]
	})
	limit = document.location.href.search(k)
	base = document.location.href.substr(0,limit)

	document.location =base + url

})

$(".image-table").click(e=>{
	$("#imageTable").attr("src",e.currentTarget.src)
	$("#imageModal").modal("show")
})

$("select").change(e=> {
	sel = e.currentTarget
	a = sel.getAttribute("children");
	if(!a.forEach)a = [a];
	a.forEach(b => {
		if(b=="")return;
		$('#'+b).data(e.currentTarget.getAttribute("name"), e.currentTarget.value)
		console.log($('#'+b).data())
		loadSelect(document.getElementById(b))
	})
})


const toBase64 = file => new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = error => reject(error);
});

$(".form-control-file").change(async function(e){
	f = e.currentTarget.files[0]

	if(f.type.split('/')[0] === "image"){
	//	console.log(await  toBase64(f))
		$("#"+$(e.currentTarget).attr("entrada")).val(await  toBase64(f))
	}

})