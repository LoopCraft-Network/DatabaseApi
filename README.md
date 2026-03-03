
# Database API

A Database API plugin made for specially LoopCraft Network with premade components and methods related database. This plugin is based on libasynql library.

For Now, this plugin stores Player's Kills, Deaths & Coins and there are specific functions coded for each data and for example to add or reduce player's Kills:

```php
//First you would need to import classes from the database api plugin.
use TarunCodes\DatabaseApi;
```

you need to register the player first with this function of the plugin:


```php
//First you would need to import classes from the database api plugin.
DatabaseApi::getInstance()->getDatabase()->initPlayerData($player); //player
```

and then call the method you need to in your function. For example:

```php
DatabaseApi::getInstance()->getDatabase()->addPlayerKills(1); //int 
```

Now, To display the a Player's specific data, You would need to use getPlayer<Data>. For example:

```php
DatabaseApi::getInstance()->getDatabase()->getPlayerKills($player); //provide the player instance.
```

That's all, Here's the Quick guide where i showed you how to use this plugin and implement it with your plugin, Feel Free to report any bugs.
