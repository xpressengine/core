dp.sh.Brushes.Java = function()
{
	var keywords =	'abstract assert boolean break byte case catch char class const ' +
			'continue default do double else enum extends ' +
			'false final finally float for goto if implements import ' +
			'instanceof int interface long native new null ' +
			'package private protected public return ' +
			'short static strictfp super switch synchronized this throw throws true ' +
			'transient try void volatile while';

	this.regexList = [
		{ regex: dp.sh.RegexLib.SingleLineCComments,							css: 'dp-comment' },		// one line comments
		{ regex: dp.sh.RegexLib.MultiLineCComments,								css: 'dp-comment' },		// multiline comments
		{ regex: dp.sh.RegexLib.DoubleQuotedString,								css: 'dp-string' },		// strings
		{ regex: dp.sh.RegexLib.SingleQuotedString,								css: 'dp-string' },		// strings
		{ regex: new RegExp('\\b([\\d]+(\\.[\\d]+)?|0x[a-f0-9]+)\\b', 'gi'),	css: 'dp-number' },		// numbers
		{ regex: new RegExp('(?!\\@interface\\b)\\@[\\$\\w]+\\b', 'g'),			css: 'dp-annotation' },	// annotation @anno
		{ regex: new RegExp('\\@interface\\b', 'g'),							css: 'dp-keyword' },		// @interface keyword
		{ regex: new RegExp(this.GetKeywords(keywords), 'gm'),					css: 'dp-keyword' }		// java keyword
		];

	this.CssClass = 'dp-j';
}

dp.sh.Brushes.Java.prototype	= new dp.sh.Highlighter();
dp.sh.Brushes.Java.Aliases	= ['java'];
