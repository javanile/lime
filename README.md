Lime: An LALR(1) parser generator in and for PHP.
=================================================

_Interpreter pattern got you down? Time to use a real parser? Welcome to Lime._


1. Use composer to install Lime.
	
	`composer require gene-sis/lime`
	
2. Build lime_scan_tokens for your development OS.
	
	For Windows run
`flex -t vendor\gene-sis\lime\scanner\lime_scan_tokens.l > vendor\gene-sis\lime\scanner\lime_scan_tokens.c`
	and
`gcc vendor\gene-sis\lime\scanner\lime_scan_tokens.c -o vendor\gene-sis\lime\scanner\lime_scan_tokens.exe`
	from the command line.
	
3. Write a grammar file
	
	Lime uses slightly modified and tweaked Backus-Naur forms.
	You can look at the .lime examples in the folder
	/vendor/gene-sis/lime/examples to understand the grammar.
	
	You can refer to your components by numbers the way BISON demands
`	exp =	exp '+' exp {
				$$ = $1 + $3;
			);`
	or assign symbolic names (similar to C-based "Lemon" parser from which
	Lime derives its name)
`	exp =	exp/a '+' exp/b {
				$$ = $a + $b;
			);`
	Oh, and one other thing: symbols are terminal if the scanner feeds them
	to the parser. They are non-terminal if they appear on the left side of
	a production rule. Lime names semantic categories using strings instead
	of the numbers that BISON-based parsers use, so you don't have to declare
	any list of	terminal symbols anywhere.
	
4. Defined pragmas
	- %namespace
		define the namespace of your parser file (enclose in single quotes)
		e.g. `%namespace 'YourProject\Extensions\Lime'`
	- %class
		define the class name of your parser
	- %start
		define the start symbol of your grammar
	- %left
	- %right
	- %nonassoc
	- %expect
	
5. Build your parser
	
	php /vendor/gene-sis/lime/lime.php path/to/your/grammar/file.lime > MyParser.php
	
6. Integrate your parser into your project
	
```php
	// below the namespace
	use YourProject\Extensions\Lime\MyParser;
	use Genesis\Lime\ParseEngine;
	use Genesis\Lime\ParseError;
	
	// create the parser instance
	$parser = new ParseEngine( new MyParser() );
	
	// run the parser
	try {
		// reset the parser
		$parser->reset();
		
		// tokenize your input with a suitable function/method and feed the
		// tokens to the parser
		foreach( tokenize( $input ) as $token ) {
			$parser->eat( $token['type'], $token['value'] );
		}
		
		// get the result
		$result = $parser->eat_eof();
		
	} catch ( ParseError $e ) {
		// handle parse errors
		$error = $e->getMessage();
	}
```
	
7. You now have the computed semantic value of whatever you parsed. Add salt
	and pepper to taste, and serve.
	
