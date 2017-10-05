# Preparing Texts and Resources for Manifold

<!-- THIS SECTION IS SPECIFIC TO THE ITERATIVE WORKFLOW; THUS THESE MATERIALS ARE ALL GRAY LIT. -->

## Text (.epub, .md, .docx, .html, Google Docs)
This unit describes elements that employ text as the primary means of conveying meaning through the Manifold Reader. Standards for ancillary or support text will be treated separately under the applicable resource types found below.

<!-- WHAT HAS TO HAPPEN? as the guiding question here. -->

_Note._ Illustrative materials embedded within text (i.e., tables, figures, etc.) will not appear in a project's Resource library.

### Style
*	Please prepare your text in accordance with the most recent edition of the _Chicago Manual of Style_ unless directed to do otherwise by your editor.

### Document Mechanics
*	Do not attempt to typeset the text in a Word Processing program. <!-- THIS NEEDS WORK. -->
*	Avoid using tabs for indents or as a means to space text for visual effect. If you are writing in a word processor, use the ruler function to implement indentation. Alternatively, abandon indents in favor of spaced paragraphs, which is preferred for both Markdown and HTML compositions.
*	Hard returns should only be used at the ends of distinct paragraphs (titles, bylines, headings, block quotes, body paragraphs) and not as a means to wrap text for the sake of appearance (e.g., to mimic original line breaks in block quotes or to impart a false hanging indent for bibliographic or reference list entries).
*	Please make sure major elements (e.g., epigraphs, headings, block quotes, lists) stand apart visually from one another—especially in making first-level headings distinct from any second- or third-level subheadings.
*	All like elements should be styled consistently (e.g., all first-level headings receive the same typographic treatment, all block quotes have the same padding around them).
*	If true underlining is to be employed (versus underlining suggesting an italic rendering), please make that known at the top of the file with a note like this: `<!-- PRESS: Underlined words in this section should appear with true underlines; any words meant to render in italics are already styled with italics. -->`. Unless so noted, we will normalize all underlining to render in italics.
*	Please consult with your editor before trying to replicate a source document's original formatting. Solutions to that question are specific to each project.

#### Things to Avoid
*	Using text boxes
*	Word art
*	Running heads/feet
*	Background images

### Scholarly Apparatus
*	If you are composing your materials in a word processor, notes—excepting those for tables—should be inserted using your program's Insert Endnote feature. The resulting notes are considered "embedded" or "linked." Embedded notes will appear as the very last element in a file. That is preferred; you do not need to gather all your notes in one file or adjust their placement in the document.

	If you are composing in Markdown, notes should be styled as Github-flavored reference links:

	```
	This sentence is annotated.[1]

	# Notes
	[1]: The note text appears here.
	```

	If you are composing in HTML, please consult with your editor for preferred note syntax.

*	To delete an embedded note in a word processor, simply delete the associated note marker in the text. To delete them in Markdown and HTML, manually delete both the marker and the associated note.
*	Please do not attempt to dis-embedded or insert new notes manually outside the confines of your program's Insert Endnote feature.
*	Avoid annotating titles, headings, or captions or having more than one note per sentence.
*	All notes need to be numbered; avoid implementing notes that are keyed to short phrases.
*	Consult with your editor before employing two sets of notes (e.g., endnotes _and_ footnotes).
*	Bibliographies or reference lists should be placed immediately after the last body paragraph and not after the linked notes section. We will adjust placement as necessary at the appropriate stage in the production process.
*	The Tables section following below provides guidance on annotating tabular materials.

### Hyperlinks
*	For text that should appear as clickable, live networked hyperlinks, please use your program's Insert Hyperlink feature. If you are composing in Markdown or HTML, please style as `[text link](http://www.text-link-url.edu)` or `<a href="http://www.text-link-url.edu">text link</a>` respectively.

### Diacriticals
*	Special characters that can't easily be found in your operating system's character map should be inserted using Unicode. For more information on available Unicode characters and how best to insert them for your system, please consult [FileFormat.Info](http://www.fileformat.info/index.htm). Mac and Windows operating systems have different means of inserting Unicode characters. Consult your editor if you need assistance.
*	If your text requires combining diacritic marks or a specific font not native to your operating system, please consult your editor on how best to proceed. Solutions to these questions are specific to each project.

<!--START HERE-->

## Tables (.docx)
Tables are text elements that efficiently convey complex information and are best reserved for collections of raw data. Compare with Lists and Figures to see which resource will best serve your materials.

*   All tables should be composed in the word processor (Word or Google Doc) in which they are to appear using the program's table features.
*	Tables should be placed specifically in the body of the document, not collected at the end.
*	Refrain from preparing or placing tabular materials as images; all tables should be editable.
*	Use tables only when doing so allows you to more efficiently convey technical or statistical information than you would be able to so with run-in text.
*	Notes for table content should appear immediately below the table and be designated by superscripted lowercase letters (a, b, c).

	Individual notes may be associated with various cells. For more information, please see _Chicago_, 16th ed., para. 3.77.

	Do _not_ include table notes in with the flow of the general article notes, so avoid using Word's insert note feature here; instead place notes to tables manually.

**Note.** Graphs and charts are considered figures and should be prepared as such. See below for more information.

<!-- For graphs and charts: add a note that these should contain data sets to recreate the materials? -->

## Lists (.docx)
Lists are discursive collections of text for comparative or outline purposes. Contrast with tables, which are highly configured and tend to be numerically driven. Below are suggestions for vertical lists. For simpler lists that appear run-in with body text, consult _Chicago_ 16th ed., para. 6.123.

*	Lists should _not_ be composed as tables but as text with a hard return after each entry.
*	If you would like two or more vertical lists to appear side by side, do not use Word tools to achieve this visually in your documents; instead simply have the lists follow one after the other and make note of how they should appear for the reader like this: `<!-- NOTE TO PRESS: If possible, these two lists should be set side by side. -->`
*	Generally we prefer to consolidate various kinds of lists to one standard—all lists are numbered or all are bulleted, for example. If your lists require separate treatment, please make that known: `<!-- NOTE TO PRESS: This list should appear with numbers; all others are okay without. -->`
<!-- Unlike Tables, lists do not need to appear on your project's media log. -->

## Figures (Print, .jpg, .tif; Electronic, 000)
<!-- We'll want to include headings for the column heads that apply in the media log here to round out what is said there. -->
Figures encompass an array of static visual elements whose meanings are imparted primarily through images instead of letters or symbols.

Figure numbers are optional and have no relation to a resource's filename; they are markers purely for reader orientation.

*	Figures should _not_ be placed directly in Word files but saved separately as standalone files.
*	Where the figure should appear for the reader, place a call-out that includes the resource filename, caption, and credit line like this:

	```
	This is the end of a body paragraph that is
	followed by a figure that has no figure number.

		figure_filename.jpg
		Caption. Credit line.

	This is the end of a body paragraph that is
	followed by a figure that does have a number
	associated with it (Figure 1).

		figure_filename.tif
		Figure 1. Caption. Credit line.
	```

	_All_ figures require some form of caption, if only to serve as a title to the resource.
*	When a figure is to be composed of multiple resource files, group the call-outs and add a note to the press.

### Reproduction Standards
*	Format: .tif or .jpg
*	Min. Resolution: 300 dpi
*	Size: Shorter dimension no less than 6 in.
*	Caption format: Figure 3.1. Descriptive caption. Credit line.
*	Include captions in the Word files where art is to be placed, or, if a piece of art has no caption, use a generic call-out in its stead, e.g., Figure 3.1. No caption.

**Note.** With the exception of those being used as historical examples, tables are never figures.

<!-- Something about static and dynamic maps here. -->
<!-- Descriptive alt tags for accessibility -->
