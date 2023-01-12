window.onload = function(){

  // Some Javascript was referenced from the Websocket guide from Mozilla.org
  // https://developer.mozilla.org/en-US/docs/Web/API/WebSockets_API/Writing_WebSocket_client_applications

  // Why did I reference this guide?
  // As I have never worked with, or have been taught about how to handle Websockets before, a guide was 
  // important to ensure the methods used were correct.

  // Pull all the info from chatRoom.php
  var form = document.getElementById('message-form');
  var messageField = document.getElementById('message');
  var messagesList = document.getElementById('messages');
  var socketStatus = document.getElementById('status');
  var closeBtn = document.getElementById('close');

  // initialize the socket variable with the websocket server link.
  // *IMPORTANT* Websocket servers cost money. This is a public link provided by piesocket. Because, i don't have money. :)
  var socket = new WebSocket('wss://demo.piesocket.com/v3/channel_123?api_key=VCXCEuvhGcBDP7XhiJJUDvR1e1D3eiVjgZ9VRiaV&notify_self');

  form.onsubmit = function(e) {
    e.preventDefault();

    // Gather the user's input from the textarea, and send it 
    var message = messageField.value;
    socket.send(message);

    // display the text to the messageList (chat log), along with the logged in user's Innie handle.
    messagesList.innerHTML += '<li class="sent"><span>' + window.userInnie + ':</span>' + message + '</li>';
    messageField.value = '';

    return false;
  };

  // When the server is plugged in, show it to the user.
  socket.onopen = function(event) {
    socketStatus.innerHTML = 'You are plugged into the room';
      socketStatus.className = 'open';
  };

  // When the user un-plugs from the chat room, let them know
  socket.onclose = function(event) {
    socketStatus.innerHTML = 'Unplugged from the room.';
    socketStatus.className = 'closed';
  };

  // Send all websocket errors to the console.log
  socket.onerror = function(error) {
      console.log('WebSocket Error: ' + error);
  };

  // Give the user the ability to disable/close the chat (connection).
  closeBtn.onclick = function(e) {
    e.preventDefault();
    // Close the WebSocket.
    socket.close();
    return false;
  };
 

};