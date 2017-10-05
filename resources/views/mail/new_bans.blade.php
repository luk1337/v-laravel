@component('mail::message')
# Hello!

You are receiving this email because someone just got banned from list 〜 {{ $list->name }}!

@component('mail::table')
| Avatar                          | Name                 | Game bans                          | VAC bans                            |
|:-------------------------------:| -------------------- |:----------------------------------:|:-----------------------------------:|
@foreach ($accounts as $account)
| ![avatar]({{$account->avatar}}) | {{ $account->name }} | {{ $account->number_of_vac_bans }} | {{ $account->number_of_game_bans }}
@endforeach
@endcomponent
@endcomponent