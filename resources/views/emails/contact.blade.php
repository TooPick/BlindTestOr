<p>
  You have received a new message from your website contact form.
</p>
<p>
  Here are the details:
</p>
<ul>
  <li>Nom: <strong>{{ $username }}</strong></li>
  <li>Email: <strong>{{ $email }}</strong></li>
  <li>Objet: <strong>{{ $object }}</strong></li>
</ul>
<hr>
<p>
	@foreach($message_body as $line)
		{{ $line }} <br/>
	@endforeach
</p>
<hr>