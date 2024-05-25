
# Ugleh.com Meme Generator

Welcome to my Meme Generator project! This repository contains open-source PHP code designed to dynamically create memes using GET parameters. It is ideal for developers looking to integrate meme generation into their own applications, such as Discord bots or web services. I use this personally with my discord bot and Chat GPT Function Calling.

## Features

- **Dynamic Image Generation:** Easily create memes by specifying parameters via GET requests.
- **Customization Options:** Add text and optionally overlay avatars/pfp to personalize memes.
- **Flexible Output Formats:** Generates memes as either raw images or saved PNG files, depending on your preference.
- **Efficient Caching:** Implements a caching system that stores up to 100 images, utilizing a FIFO strategy for image management.

## Installation

This project depends on PHP and the Imagick extension for image manipulation. To set up Imagick on your server, follow these installation instructions:

```bash
# For Ubuntu
sudo apt-get install php-imagick

# For CentOS
sudo yum install php-imagick

# Don't forget to restart your web server after installation
sudo service apache2 restart  # For Apache
sudo service nginx restart   # For Nginx
```

Ensure Imagick is enabled in your `php.ini`:

```ini
extension=imagick.so
```

## Example API Usage

The following are example API endpoints demonstrating how to use the meme generator. These endpoints are part of the demo provided in this repository and are meant to serve as a basis for your own implementations.

### 1. Bitches Don't Know
- **Method:** GET
- **Demo URL:** `https://ugleh.com/imagegen/?type=bitchesdontknow`
- **Parameters:**
  - `text` (string): Text to overlay on the image.
  - `avatar` (string, optional): Image to overlay over the character's head.
- **Response Example:**
  ```json
  {
    "success": true,
    "image": "https://ugleh.com/imagegen/i/......png"
  }
  ```

### 2. Hard Pill
- **Method:** GET
- **Demo URL:** `https://ugleh.com/imagegen/?type=hardpills`
- **Parameters:**
  - `text` (string): Text to overlay on the image.
- **Response Example:**
  ```json
  {
    "success": true,
    "image": "https://ugleh.com/imagegen/i/......png"
  }
  ```

### 3. Gee Bill
- **Method:** GET
- **Demo URL:** `https://ugleh.com/imagegen/?type=geebill`
- **Parameters:**
  - `prompt` (string): The question part of "Gee Bill How Come Your Mom Lets You _____?"
  - `answer` (string): Bill's response.
  - `name2` (string, optional): Alternate name for Bill.
  - `avatar1` (string, optional): Avatar for the question asker.
  - `avatar2` (string, optional): Avatar for Bill.
- **Response Example:**
  ```json
  {
    "success": true,
    "image": "https://ugleh.com/imagegen/i/......png"
  }
  ```

## Usage

To use any of the demo endpoints, send a GET request with the required parameters. Example using cURL:

```bash
curl "https://ugleh.com/imagegen/?type=geebill&prompt=eat%20two%20wieners&answer=Three%20Wieners&name2=Ugleh&raw=1"
```

## Contributing

Contributions are welcome! If you have ideas for new features, improvements, or want to add new templates, please fork this repository, make your changes, and submit a pull request.

## License

This project is licensed under the GNU General Public License - see the LICENSE.md file for details.
