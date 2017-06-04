# Telegram finance bot

The Telegram finance bot can keep track of your spendings, and store them into a .csv file, 
which can then be used in other programs

## Setup

1. Create a bot with the[Botfather](https://t.me/BotFather)
2. Replace the values in config.php.example to the actual values of your bot instance obtained from The Botfather, 
then rename to config.php.
3. Upload the files to the server.
4. Replace the URL in setup.php to your actual bot URL, 
then run it.

## Commands
* **/add**: Add a new spending in the format `/add amount name`
* **/remove**: Remove previous spending
* **/status**: Returns total spending in the current month
* **/list**: Lists all spending in the current month