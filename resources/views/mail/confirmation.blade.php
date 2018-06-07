Hi {{ $name }},
    <p> Your registration is completed. Please click the link below to login. </p>

{{ route('confirmation',$token) }}
