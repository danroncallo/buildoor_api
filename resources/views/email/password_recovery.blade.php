<h3>Enviado por: {{$email->name}}</h3>
<br>
<p>{{$email->message}}</p>
<br>
<h3>Contacto: {{$email->email}}</h3>
<br>
<h4> Hora: {{Carbon\Carbon::now()->format('d/m/Y: h:m:s')}}</h4>






