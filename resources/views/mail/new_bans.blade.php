@component('mail::message')
# Hello!

You are receiving this email because someone just got banned from list 〜 {{ $list->name }}!

@component('mail::html')
<div class="table">
    <table>
        <thead>
        <tr>
            <th>Avatar</th>
            <th>Name</th>
            <th>Game bans</th>
            <th>VAC bans</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($accounts as $account)
                <tr>
                    <td style="text-align: center"><img src="{{ $account->avatar }}" /></td>
                    <td><a href="https://steamcommunity.com/profiles/{{ $account->steamid }}">{{ $account->name }}</a></td>
                    <td style="text-align: center">{{ $account->number_of_game_bans }}</td>
                    <td style="text-align: center">{{ $account->number_of_vac_bans }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endcomponent
@endcomponent