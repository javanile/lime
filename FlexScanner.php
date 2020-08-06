<?php
/**
 * Let's face it: PHP is not up to lexical processing. GNU flex handles
 * it well, so I've created a little protocol for delegating the work.
 * Extend this class so that executable() gives a path to your lexical
 * analyser program.
 */

namespace Genesis\Lime;

 abstract class FlexScanner {
	abstract function executable();

	public function __construct($path) {
		if (!is_readable($path)) {
			throw new \Exception("$path is not readable.");
		}

		$scanner = $this->executable();

		$tokens = explode("\0", shell_exec($scanner . ' < ' . $path));

		array_pop($tokens);
		$this->tokens = $tokens;
		$this->lineno = 1;
	}

	public function next() {
		if (list($key, $token) = each($this->tokens)) {
			list($this->lineno, $type, $text) = explode("\1", $token);

			return array($type, $text);
		}
	}

	public function feed($parser) {
		while (list($type, $text) = $this->next()) {
			$parser->eat($type, $text);
		}

		return $parser->eat_eof();
	}
}
