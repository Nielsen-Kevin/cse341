<?php
class Upload {
	private $name;
	private $filename;
	private $directory;
	private $error;

	public function __construct($name, $directory) {
		$this->name = $name;
		// Gets the actual file name
		$this->filename = $this->cleanName($name);
		$this->directory = rtrim($directory, '/');
		$this->error = false;
	}

	public function __set($key, $value) {
		$this->$key = $value;
	}

	public function __get($key) {
		return (isset($this->$key) ? $this->$key : null);
	}

	public function cleanName($name) {
		if (!empty($_FILES[$name]['name'])) {
			// Sanitize the filename
			return basename(html_entity_decode($_FILES[$name]['name'], ENT_QUOTES, 'UTF-8'));
		}
	}

	public function image() {
		$name = $this->name;

		if (!empty($_FILES[$name]['name']) && is_file($_FILES[$name]['tmp_name'])) {

			// Validate the filename length
			if ((utf8_strlen($this->filename) < 3) || (utf8_strlen($this->filename) > 255)) {
				$this->error = 'Warning: Filename must be a between 3 and 255!';
			}

			// Allowed file extension types
			$allowed = array(
				'jpg',
				'jpeg',
				'gif',
				'png'
			);

			if (!in_array(utf8_strtolower(utf8_substr(strrchr($this->filename, '.'), 1)), $allowed)) {
				$this->error = 'Warning: Incorrect file type!';
			}

			// Allowed file mime types
			$allowed = array(
				'image/jpeg',
				'image/pjpeg',
				'image/png',
				'image/x-png',
				'image/gif'
			);

			if (!in_array($_FILES[$name]['type'], $allowed)) {
				$this->error = 'Warning: Incorrect file type!';
			}

			// Check to see if any PHP files are trying to be uploaded
			$content = file_get_contents($_FILES[$name]['tmp_name']);

			if (preg_match('/\<\?php/i', $content)) {
				$this->error = 'Warning: Incorrect file type!';
			}

			// Return any upload error
			if ($_FILES[$name]['error'] != UPLOAD_ERR_OK) {
				$this->error = 'Error: ' . $_FILES[$name]['error'];
			}
		} else {
			$this->error = 'Warning: File could not be uploaded for an unknown reason!';
		}
		
		if (!$this->error) {
			move_uploaded_file($_FILES[$name]['tmp_name'], $this->directory . '/' . $this->filename);
		}
		return $this->filename;
	}
}