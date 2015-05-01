<h1>LolClass</h1>

<h2>How To Use The Class</h2>

<h4>User Info</h4>
<code>$lol = new LolClass();</code>
<br>
<code>print_r($lol->region('tr')->name('UndyingEye')->summoner_info()); // User Info (Summoner Name)</code>
<br>
<code>print_r($lol->region('tr')->id('178866')->summoner_info()); // User Info (Summoner Id)</code>

</code>

<h4>Current Game</h4>
<code>$lol = new LolClass();</code>
<br>
<code>print_r($lol->region('tr')->id('178866')->current_game('TR1'));</code>

<h4>Champion</h4>
<code>$lol = new LolClass();</code>
<br>
<code>print_r($lol->region('tr')->champion_info()); // Champion Info (ALL)</code>
<br>
<code>print_r($lol->region('tr')->champion_info('16')); // Champion Info (Champion Id)</code>

<h2>Author Information</h2>
<span>Author: Ahmet Işıtan Narlı</span>
<br>
<span>Mail: ahmetisitannarli@gmail.com</span>
<br>
<span>Facebook Profile: <a href="https://facebook.com/isitan.narli">fb.com/isitan.narli</a></span>
<br>
<span>Twitter Profile: <a href="https://twitter.com/isitannarli">twitter.com/isitannarli</a></span>

<h2>Source</h2>
<a href="https://developer.riotgames.com">Riot Games API</a>
