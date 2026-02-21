<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use App\Models\Subscriber;
use Illuminate\Contracts\Database\Eloquent\Builder;

class SubscriberController extends Controller
{
  public function index(EmailList $emailList)
  {
    $search = request()->search;

    $showTrash = request()->get('showTrash', false);

    $subscribers = $emailList
      ->subscribers()
      ->when(
        $showTrash,
        fn(Builder $query) => $query->withTrashed()
      )
      ->when(
        $search,
        fn(Builder $query) => $query
          ->where('name', 'like', "%$search%")
          ->orWhere('email', 'like', "%$search%")
          ->orWhere('id', '=', $search)
      )
      ->paginate()
      ->appends(compact('search', 'showTrash'));

    return view('subscribers.index', [
      'emailList' => $emailList,
      'subscribers' => $subscribers,
      'search' => $search,
      'showTrash' => $showTrash,
    ]);
  }

  public function destroy(EmailList $emailList, Subscriber $subscriber)
  {
    $subscriber->delete();

    return back()->with('message', __('Subscriber deleted from the list!'));
  }
}
