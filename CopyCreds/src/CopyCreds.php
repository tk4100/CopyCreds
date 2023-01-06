<?php

namespace MediaWiki\Extension\CopyCreds;

use MediaWiki\Hook\ParserFirstCallInitHook;
use MediaWiki\Hook\BeforePageDisplayHook;
use Parser;
use PPFrame;

// hooks the parser for <un> and <pw> tags.  Does coloring, and sets the onClick()
class CopyCreds implements ParserFirstCallInitHook {
	// Register hooks for certain tags 
	public function onParserFirstCallInit($parser) {
		$parser->setHook('un', [ $this, 'renderUsername' ]);
		$parser->setHook('pw', [ $this, 'renderPassword' ]);
	}

	// do the same text modification with different colors based on the tag.
	public function renderUsername( $in, array $param, Parser $parser, PPFrame $frame) {
		$rendered = $this->renderThing($in, "#FFC0C0");
		return array($rendered, "markerType" => "nowiki");
	}
	public function renderPassword( $in, array $param, Parser $parser, PPFrame $frame) {
		$rendered = $this->renderThing($in, "#C0C0FF");
		return array($rendered, "markerType" => "nowiki");
	}

	// does the actual rendering with color as arg, avoiding duplication.
	public function renderThing($input, $color) {
		$randid = strval(rand(1,100000000));
	
		$input = htmlspecialchars($input);

	        $output = "<span 
		id=\"$randid\" 
		style=\"font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace; cursor: pointer; background-color: #F8F9FA; border: 1px solid $color\" 
		title=\"Click to copy\"
		onclick=\"copy_clip('$randid')\">$input</span>";

	        return($output);
	}
}

// prepends a script block to the final render of the wiki page, which implements the onClick set in CopyCreds above.
class CopyOnClick implements BeforePageDisplayHook {
	public function onBeforePageDisplay($out, $skin): void {
		$out->addScriptFile("$wgScriptPath/extensions/CopyCreds/src/copylink.js");
	}
}
?>
