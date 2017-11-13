/**
 * Example input:
 *     1aa入力してください<font color="#ff00cc">aaaabbbaaa</font>aaana4
 * Output:
 *    <font color="#000000">1aa入力してください</font>
 *    <font color="#ff00cc">aaaabbbaaa</font>
 *    <font color="#000000">aaana4</font>
 */
function find_text_change_to_font_black(text) {
    //find text single not include tag
    var regex = /(\w|[\u3000-\u303F]|[\u3040-\u309F]|[\u30A0-\u30FF]|[\uFF00-\uFFEF]|[\u4E00-\u9FAF]|[\u2605-\u2606]|[\u2190-\u2195]|\u203B)+(?![^<]*>|[^<>]*<\/)/g;

    var result = text.replace(regex, function(string) {
        //replace text by tag with color is black.
        return '<font color="#000000">'+string+'</font>';
    });

    return result;
}
