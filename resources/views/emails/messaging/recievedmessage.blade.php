{{ nl2br($messageModel->body) }}
<br>
<a href="{{ route('messages.show', ['id' => $messageModel->thread->id]) }}">Click here to reply</a>
