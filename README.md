# Telegram finance bot

The Telegram finance bot can keep track of your spendings, and store them into a .csv file, 
which can then be used in other programs

## Setup

1. Create a bot with the [Botfather](https://t.me/BotFather). You will receive an API key.
2. Replace the values in config.php.example to the actual values of your bot instance obtained from The Botfather.
3. Replace TG_USER_ID with your User ID. See below if you do not know your user ID. It is different from your username.
4. Rename config.php.example to config.php.
5. Replace the URL in setup.php to your actual bot URL.
6. Upload the files to your server. Remember that your web server must support https.
7. Run setup.php
8. Run the command `/setcommands` on the Botfather, then submit the contents of setcommands.txt.

### User ID
To check your user id, please complete the steps above, then run the command `/userid`. Then complete step 3.

The reason for hardcoding the user ID into the code is to ensure no other people can access your bot, 
even if the accidently stumble upon it.

## Commands
* **/add**: Add a new spending in the format `/add amount name`. Example: `/add 31.41 10 Pumpkin Pies`
* **/remove**: Remove previous spending
* **/status**: Returns total spending in the current month
* **/list**: Lists all spending in the current month