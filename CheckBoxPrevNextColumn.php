<?php
/**
 * @author Vinny Freire <vinny.freire@gmail.com>
 * @package application.modules.migration.components
 * @since 1.0
 */
class CheckBoxPrevNextColumn extends CCheckBoxColumn
{

    public $orientation = 'prevAll';

    /**
     * Initializes the column.
     * This method registers necessary client script for the checkbox column.
     */
    public function init()
    {
        if(isset($this->checkBoxHtmlOptions['name']))
            $name = $this->checkBoxHtmlOptions['name'];
        else
        {
            $name = $this->id;
            if(substr($name, -2) !== '[]')
                $name.='[]';
            $this->checkBoxHtmlOptions['name'] = $name;
        }
        $name = strtr($name, array('[' => "\\[", ']' => "\\]"));

        $js = <<<EOD
jQuery(document).on('click', "input[name='$name']", function() {
        var cc = this.checked;
        $(this).parents('tr').eq(0).{$this->orientation}('tr').find('input[type=checkbox]').each(function(x, item){
                item.disabled = item.checked = cc;
        });
                        
        return true;
});
EOD;
        Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $this->id, $js);
    }

}
?>