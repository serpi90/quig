# QUIG

Quote Image Generator: PHP scripts to generate png images from quotes.

## Usage

- `generateAll.php` loads al availale phrases and generates the images.
- `change.php` changes the current `phrase.png` file to one chosen at random from all the available images (if the image for the chosen phrase has not been written ti will be written.

## Initial configuration

1. Configure fonts and size if you need to, in `config.php`.
2. Make sure the `images` directory exists and has write access. (All the generated images go here).
3. Make sure `phrase.png` file can be written. Either
    - The root folder can have write access (less recommended).
    - The file already exists and has write access.
4. Somehow fill loadPhrases.php with your phrases. (mysql, csv, sqlite, google spreadsheets, anything you want)
