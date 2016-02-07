<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Repositories\Messenger\Message\MessageRepository;

class NavbarComposer
{
    /**
     * The message repository implementation.
     *
     * @var UserRepository
     */
    protected $message;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(MessageRepository $message)
    {
        // Dependencies automatically resolved by service container...
        $this->message = $message;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
      $message_count = 0;
      if(\Auth::check())
      {
        $message_count = $this->message->countUsersUnread(\Auth::id());
      }

      $view->with('message_count', $message_count);
    }
}
