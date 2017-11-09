/**
 * Cut num character of string include strip_tags
 * 
 * @param $text
 * @param $max_length
 * @return string
 */
public function html_cut($text, $max_length) {
    $tags   = array();
    $result = "";

    $is_open   = false;
    $grab_open = false;
    $is_close  = false;
    $in_double_quotes = false;
    $in_single_quotes = false;
    $tag = "";

    $i = 0;
    $stripped = 0;

    $stripped_text = strip_tags($text);

    while( $i < mb_strlen($text, 'SJIS')
        && $stripped < mb_strlen($stripped_text, 'SJIS')
        && $stripped < $max_length
    ) {
        $symbol  = mb_substr($text, $i, 1, 'SJIS');
        $result .= $symbol;

        switch ($symbol) {
            case '<':
                $is_open   = true;
                $grab_open = true;
                break;

            case '"':
                if ($in_double_quotes)
                    $in_double_quotes = false;
                else
                    $in_double_quotes = true;

                break;

            case "'":
                if ($in_single_quotes)
                    $in_single_quotes = false;
                else
                    $in_single_quotes = true;

                break;

            case '/':
                if ($is_open && !$in_double_quotes && !$in_single_quotes)
                {
                    $is_close  = true;
                    $is_open   = false;
                    $grab_open = false;
                }

                break;

            case ' ':
                if ($is_open)
                    $grab_open = false;
                else
                    $stripped++;

                break;

            case '>':
                if ($is_open)
                {
                    $is_open   = false;
                    $grab_open = false;
                    array_push($tags, $tag);
                    $tag = "";
                }
                else if ($is_close)
                {
                    $is_close = false;
                    array_pop($tags);
                    $tag = "";
                }

                break;

            default:
                if ($grab_open || $is_close)
                    $tag .= $symbol;

                if (!$is_open && !$is_close)
                    $stripped++;
        }

        $i++;
    }

    while ($tags) {
        $result .= "</".array_pop($tags).">";
    }

    if (mb_strlen($stripped_text, 'SJIS') > $max_length) {
        $result .= '...';
    }

    return $result;
}
