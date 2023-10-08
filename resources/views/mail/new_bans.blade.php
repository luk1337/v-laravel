@component('mail::message')
# @lang('Hello!')

@lang('You are receiving this email because someone just got banned from list 〜 :name', ['name' => App\Helpers\MarkdownHelper::markdownEscape($list->name)])

@component('mail::table')
| @lang('Avatar')                 | @lang('Name')                                                                                   | @lang('Community banned')           | @lang('Game bans')                  | @lang('VAC bans')                  |
|:-------------------------------:| ----------------------------------------------------------------------------------------------- |:-----------------------------------:|:-----------------------------------:|:----------------------------------:|
@foreach ($accounts as $account)
| [![avatar]({{ $account->getAvatar() }})](https://steamcommunity.com/profiles/{{ $account->steamid }}) | [@escape_markdown($account->name)](https://steamcommunity.com/profiles/{{ $account->steamid }}) | {{ $account->community_banned ? __('Yes') : __('No') }} | {{ $account->number_of_game_bans }} | {{ $account->number_of_vac_bans }}
@endforeach
@endcomponent
@endcomponent
