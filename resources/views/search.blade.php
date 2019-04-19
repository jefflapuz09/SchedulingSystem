<html>
    <!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  <script>

    // Enable pusher logging - don't include this in production
    //Pusher.logToConsole = true;

    var pusher = new Pusher('a07b0f4928ae83a12227', {
      cluster: 'ap1',
      forceTLS: true
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('searchUser', function(data) {
      if(JSON.stringify(data.search) != null){
          name = data.search.name;
          name = name.replace(/"/g, "'");
          alert('Hello '+name);
      }
    });
  </script>
</head>
<body>
  <h1>Pusher Test</h1>
  <p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
  </p>
</body>

</html>