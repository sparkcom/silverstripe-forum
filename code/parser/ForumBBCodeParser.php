<?php
/**
 * Created by PhpStorm.
 * User: ben
 * Date: 27/12/2018
 * Time: 07:40
 */

namespace SilverStripe\Forum\Parser;

     use Genert\BBCode\Parser\Parser;
     use SilverStripe\ORM\ArrayList;
     use SilverStripe\View\ArrayData;

     class ForumBBCodeParser extends Parser
    {
        protected $parsers = [
            'h1' => [
                'pattern' => '/\[h1\](.*?)\[\/h1\]/s',
                'replace' => '<h1>$1</h1>',
                'content' => '$1'
            ],
            'h2' => [
                'pattern' => '/\[h2\](.*?)\[\/h2\]/s',
                'replace' => '<h2>$1</h2>',
                'content' => '$1'
            ],
            'h3' => [
                'pattern' => '/\[h3\](.*?)\[\/h3\]/s',
                'replace' => '<h3>$1</h3>',
                'content' => '$1'
            ],
            'h4' => [
                'pattern' => '/\[h4\](.*?)\[\/h4\]/s',
                'replace' => '<h4>$1</h4>',
                'content' => '$1'
            ],
            'h5' => [
                'pattern' => '/\[h5\](.*?)\[\/h5\]/s',
                'replace' => '<h5>$1</h5>',
                'content' => '$1'
            ],
            'h6' => [
                'pattern' => '/\[h6\](.*?)\[\/h6\]/s',
                'replace' => '<h6>$1</h6>',
                'content' => '$1'
            ],
            'bold' => [
                'pattern' => '/\[b\](.*?)\[\/b\]/s',
                'replace' => '<b>$1</b>',
                'content' => '$1'
            ],
            'italic' => [
                'pattern' => '/\[i\](.*?)\[\/i\]/s',
                'replace' => '<i>$1</i>',
                'content' => '$1'
            ],
            'underline' => [
                'pattern' => '/\[u\](.*?)\[\/u\]/s',
                'replace' => '<u>$1</u>',
                'content' => '$1'
            ],
            'strikethrough' => [
                'pattern' => '/\[s\](.*?)\[\/s\]/s',
                'replace' => '<s>$1</s>',
                'content' => '$1'
            ],
            'quote' => [
                'pattern' => '/\[quote\](.*?)\[\/quote\]/s',
                'replace' => '<blockquote>$1</blockquote>',
                'content' => '$1'
            ],
            'link' => [
                'pattern' => '/\[url\](.*?)\[\/url\]/s',
                'replace' => '<a href="$1">$1</a>',
                'content' => '$1'
            ],
            'namedlink' => [
                'pattern' => '/\[url\=(.*?)\](.*?)\[\/url\]/s',
                'replace' => '<a href="$1">$2</a>',
                'content' => '$2'
            ],
            'image' => [
                'pattern' => '/\[img\](.*?)\[\/img\]/s',
                'replace' => '<img src="$1" style="max-width: 100%">',
                'content' => '$1'
            ],
            'orderedlistnumerical' => [
                'pattern' => '/\[list=1\](.*?)\[\/list\]/s',
                'replace' => '<ol>$1</ol>',
                'content' => '$1'
            ],
            'orderedlistalpha' => [
                'pattern' => '/\[list=a\](.*?)\[\/list\]/s',
                'replace' => '<ol type="a">$1</ol>',
                'content' => '$1'
            ],
            'unorderedlist' => [
                'pattern' => '/\[list\](.*?)\[\/list\]/s',
                'replace' => '<ul>$1</ul>',
                'content' => '$1'
            ],
            'listitem' => [
                'pattern' => '/\[\*\](.*)/',
                'replace' => '<li>$1</li>',
                'content' => '$1'
            ],
            'code' => [
                'pattern' => '/\[code\](.*?)\[\/code\]/s',
                'replace' => '<code>$1</code>',
                'content' => '$1'
            ],
            'youtube' => [
                'pattern' => '/\[youtube\](.*?)\[\/youtube\]/s',
                'replace' => '<iframe width="560" style="max-width: 100%" height="315" src="//www.youtube-nocookie.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
                'content' => '$1'
            ],
            'sub' => [
                'pattern' => '/\[sub\](.*?)\[\/sub\]/s',
                'replace' => '<sub>$1</sub>',
                'content' => '$1'
            ],
            'sup' => [
                'pattern' => '/\[sup\](.*?)\[\/sup\]/s',
                'replace' => '<sup>$1</sup>',
                'content' => '$1'
            ],
            'small' => [
                'pattern' => '/\[small\](.*?)\[\/small\]/s',
                'replace' => '<small>$1</small>',
                'content' => '$1'
            ],
            'table' => [
                'pattern' => '/\[table\](.*?)\[\/table\]/s',
                'replace' => '<table>$1</table>',
                'content' => '$1',
            ],
            'table-row' => [
                'pattern' => '/\[tr\](.*?)\[\/tr\]/s',
                'replace' => '<tr>$1</tr>',
                'content' => '$1',
            ],
            'table-data' => [
                'pattern' => '/\[td\](.*?)\[\/td\]/s',
                'replace' => '<td>$1</td>',
                'content' => '$1',
            ],

            'color' => [
                'pattern' => '/\[color=(.*?)\](.*?)\[\/color\]/s',
                'replace' => '<span style="color: $1">$2</span>',
                'content' => '$2'
            ],
            'email' => [
                'pattern' => '/\[email\](.*?)\[\/email\]/s',
                'replace' => '<a href="mailto:$1">$1</a>',
                'content' => '$1'
            ],
            'emailmore' => [
                'pattern' => '/\[email=(.*?)\](.*?)\[\/email\]/s',
                'replace' => '<a href="mailto: $1">$2</a>',
                'content' => '$2'
            ],

        ];

        public function stripTags(string $source): string
        {
            foreach ($this->parsers as $name => $parser) {
                $source = $this->searchAndReplace($parser['pattern'] . 'i', $parser['content'], $source);
            }

            return $source;
        }

        public function parse(string $source, $caseInsensitive = null): string
        {
            $caseInsensitive = $caseInsensitive === self::CASE_INSENSITIVE ? true : false;

            foreach ($this->parsers as $name => $parser) {
                $pattern = ($caseInsensitive) ? $parser['pattern'] . 'i' : $parser['pattern'];

                $source = $this->searchAndReplace($pattern, $parser['replace'], $source);
            }

            return $source;
        }

        public static function usable_tags (){
            return  new ArrayList([
                    new ArrayData(array(
                        "Title" => _t('BBCodeParser.BOLD', 'Bold Text'),
                        "Example" => '[b]<b>'._t('BBCodeParser.BOLDEXAMPLE', 'Bold').'</b>[/b]'
                    )),
                    new ArrayData(array(
                        "Title" => _t('BBCodeParser.ITALIC', 'Italic Text'),
                        "Example" => '[i]<i>'._t('BBCodeParser.ITALICEXAMPLE', 'Italics').'</i>[/i]'
                    )),
                    new ArrayData(array(
                        "Title" => _t('BBCodeParser.UNDERLINE', 'Underlined Text'),
                        "Example" => '[u]<u>'._t('BBCodeParser.UNDERLINEEXAMPLE', 'Underlined').'</u>[/u]'
                    )),
                    new ArrayData(array(
                        "Title" => _t('BBCodeParser.STRUCK', 'Struck-out Text'),
                        "Example" => '[s]<s>'._t('BBCodeParser.STRUCKEXAMPLE', 'Struck-out').'</s>[/s]'
                    )),
                    new ArrayData(array(
                        "Title" => _t('BBCodeParser.COLORED', 'Colored text'),
                        "Example" => '[color=blue]'._t('BBCodeParser.COLOREDEXAMPLE', 'blue text').'[/color]'
                    )),

                    new ArrayData(array(
                        "Title" => _t('BBCodeParser.CODE', 'Code Block'),
                        "Description" => _t('BBCodeParser.CODEDESCRIPTION', 'Unformatted code block'),
                        "Example" => '[code]'._t('BBCodeParser.CODEEXAMPLE', 'Code block').'[/code]'
                    )),
                    new ArrayData(array(
                        "Title" => _t('BBCodeParser.EMAILLINK', 'Email link'),
                        "Description" => _t('BBCodeParser.EMAILLINKDESCRIPTION', 'Create link to an email address'),
                        "Example" => "[email]you@yoursite.com[/email]"
                    )),
                    new ArrayData(array(
                        "Title" => _t('BBCodeParser.EMAILLINK', 'Email link'),
                        "Description" => _t('BBCodeParser.EMAILLINKDESCRIPTION', 'Create link to an email address'),
                        "Example" => "[email=you@yoursite.com]Email[/email]"
                    )),
                    new ArrayData(array(
                        "Title" => _t('BBCodeParser.UNORDERED', 'Unordered list'),
                        "Description" => _t('BBCodeParser.UNORDEREDDESCRIPTION', 'Unordered list'),
                        "Example" => '[list][*]'._t('BBCodeParser.UNORDEREDEXAMPLE1', 'unordered item 1').'[*] unordered item 2[/list]'
                    )),
                    new ArrayData(array(
                        "Title" => _t('BBCodeParser.IMAGE', 'Image'),
                        "Description" => _t('BBCodeParser.IMAGEDESCRIPTION', 'Show an image in your post'),
                        "Example" => "[img]http://www.website.com/image.jpg[/img]"
                    )),

                    new ArrayData(array(
                        "Title" => _t('BBCodeParser.YOUTUBE', 'Youtube'),
                        "Description" => _t('BBCodeParser.YOUTUBEDESCRIPTION', 'Show Youtube video in your post'),
                        "Example" => "[youtube]youtube_video_id[/youtube]"
                    )),
                    new ArrayData(array(
                        "Title" => _t('BBCodeParser.LINK', 'Website link'),
                        "Description" => _t('BBCodeParser.LINKDESCRIPTION', 'Link to another website or URL'),
                        "Example" => '[url]http://www.website.com/[/url]'
                    )),
                    new ArrayData(array(
                        "Title" => _t('BBCodeParser.LINK', 'Website link'),
                        "Description" => _t('BBCodeParser.LINKDESCRIPTION', 'Link to another website or URL'),
                        "Example" => "[url=http://www.website.com/]Website[/url]"
                    ))]
            );
        }
    }

