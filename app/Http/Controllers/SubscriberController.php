<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use App\Models\Subscriber;
// use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

class SubscriberController extends Controller
{
  public function index(EmailList $emailList)
  {
    $search = request()->search;

    $withTrashed = request()->get('withTrashed', false);

    return view('subscribers.index', [
      'emailList' => $emailList,
      'subscribers' => $emailList
        ->subscribers()
        ->when($withTrashed, fn(Builder $query) => $query->withTrashed())
        ->when($search, fn(Builder $query) => $query->where('name', 'like', "%$search%")
          ->orWhere('email', 'like', "%$search%")
          ->orWhere('like', '=', "$search"))
        ->paginate()
        ->appends(compact('search', 'withTrashed')),
      'search' => $search,
      'withTrashed' => $withTrashed
    ]);
  }
  public function create(EmailList $emailList)
  {
    return view('subscribers.create', compact('emailList'));
  }

  public function store(EmailList $emailList)
  {
    $data = request()->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'email', 'max:255', Rule::unique('subscribers')->where('email_list_id', $emailList->id)]
    ]);

    $emailList->subscribers()->create($data);

    return to_route('subscribers.index', $emailList)
      ->with('message', __('Subscriber successfully created!'));
  }

  public function destroy(EmailList $emailList, Subscriber $subscriber)
  {
    $subscriber->delete();

    return back()->with('message', __('Subscriber deleted from the list!'));
  }
}
