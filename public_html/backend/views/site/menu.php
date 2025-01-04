<?php

use \common\models\Post;
use common\models\Category;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html lang="en" class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html lang="en" class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html lang="en" class="lt-ie9"> <![endif]-->
<!--[if IE 9]>    <html lang="en" class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
        <title>Nestable</title>
        <style type="text/css">

            /**
             * Nestable
             */

            .dd { position: relative; display: block; margin: 0; padding: 0; max-width: 600px; list-style: none; font-size: 13px; line-height: 20px; }

            .dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
            .dd-list .dd-list { padding-left: 30px; }
            .dd-collapsed .dd-list { display: none; }

            .dd-item,
            .dd-empty,
            .dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }

            .dd-handle { display: block; height: 30px; margin: 5px 0; padding: 5px 10px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
                         background: #fafafa;
                         background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
                         background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
                         background:         linear-gradient(top, #fafafa 0%, #eee 100%);
                         -webkit-border-radius: 3px;
                         border-radius: 3px;
                         box-sizing: border-box; -moz-box-sizing: border-box;
            }
            .dd-handle:hover { color: #2ea8e5; background: #fff; }

            .dd-handle:hover { color: #2ea8e5; background: #fff; }

            .dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
            .dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
            .dd-item > button[data-action="collapse"]:before { content: '-'; }
            .dd-item > button[data-action="delete"]:before { content: 'x'; }
            .dd-placeholder,
            .dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }


            .dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
            .dd-dragel > .dd-item .dd-handle { margin-top: 0; }
            .dd-dragel .dd-handle {
                -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
                box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
            }

            /**
             * Nestable Extras
             */

            .nestable-lists { display: block; padding: 30px 0; width: 100%; border: 0; }

            #nestable-menu { padding: 0; margin: 20px 0; }

            #nestable-output,
            #nestable2-output { width: 100%; height: 7em; font-size: 0.75em; line-height: 1.333333em; font-family: Consolas, monospace; padding: 5px; box-sizing: border-box; -moz-box-sizing: border-box; }

            #nestable2 .dd-handle {
                color: #fff;
                border: 1px solid #999;
                background: #bbb;
                background: -webkit-linear-gradient(top, #bbb 0%, #999 100%);
                background:    -moz-linear-gradient(top, #bbb 0%, #999 100%);
                background:         linear-gradient(top, #bbb 0%, #999 100%);
            }
            #nestable2 .dd-handle:hover { background: #bbb; }
            #nestable2 .dd-item > button:before { color: #fff; }

            @media only screen and (min-width: 700px) {

                .dd { float: left; width: 48%; }
                .dd + .dd { margin-left: 2%; }

            }

            .dd-hover > .dd-handle { background: #2ea8e5 !important; }

            /**
             * Nestable Draggable Handles
             */

            .dd3-content { display: block; height: 30px; margin: 5px 0; padding: 5px 10px 5px 40px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
                           background: #fafafa;
                           background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
                           background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
                           background:         linear-gradient(top, #fafafa 0%, #eee 100%);
                           -webkit-border-radius: 3px;
                           border-radius: 3px;
                           box-sizing: border-box; -moz-box-sizing: border-box;
            }
            .dd3-content:hover { color: #2ea8e5; background: #fff; }

            .dd-dragel > .dd3-item > .dd3-content { margin: 0; }

            .dd3-item > button { margin-left: 30px; }

            .dd3-handle { position: absolute; margin: 0; left: 0; top: 0; cursor: pointer; width: 30px; text-indent: 100%; white-space: nowrap; overflow: hidden;
                          border: 1px solid #aaa;
                          background: #ddd;
                          background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
                          background:    -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
                          background:         linear-gradient(top, #ddd 0%, #bbb 100%);
                          border-top-right-radius: 0;
                          border-bottom-right-radius: 0;
            }
            .dd3-handle:before { content: '≡'; display: block; position: absolute; left: 0; top: 3px; width: 100%; text-align: center; text-indent: 0; color: #fff; font-size: 20px; font-weight: normal; }
            .dd3-handle:hover { background: #ddd; }

            /**
             * Socialite
             */

            .socialite { display: block; float: left; height: 35px; }
            #nestable-output{
                display: none2;
            }
            .dd-item > button[data-action="delete"]:before { content: 'x'; color: red; }
            span.mega_check {
                position: absolute;
                left: 64px;
                top: 6px;
                direction: ltr;
            }

            span.thumb_check {
                position: absolute;
                left: 40px;
                top: 6px;
                direction: ltr;
            }


            .mega_check input {
                margin-right: 8px;
            }
        </style>


    <div class="cf nestable-lists">

        <div class="dd col-md-8 col-md-push-4 col-xs-12" id="nestable">
            <ol class="dd-list">


                <?php
                $post_array = array();
                $cat_array = array();
                $product_cat_array = array();

                function get_item_name($item_id, &$post_array, &$cat_array, &$product_cat_array) { // need pass by reference 
                    if (substr($item_id, 0, 1) == "p") {
                        array_push($post_array, substr($item_id, 2));

                        return Post::findOne(substr($item_id, 2))->title;
                    } elseif (substr($item_id, 0, 1) == "c") {
                        array_push($cat_array, substr($item_id, 2));
                        return Category::findOne(substr($item_id, 2))->name;
                    } else {
                        array_push($product_cat_array, substr($item_id, 2));
                        return common\models\ProductCategory::findOne(substr($item_id, 2))->name . "-" . $item_id;
                    }
                }

                $m = \common\models\Sitesetting::findOne(1);

//echo $m->option_value;

                $array = ((json_decode($m->option_value)));

                //print_r($array);

                foreach ((array)$array as $items) {
                    ?>
                    <li class="dd-item" data-id="<?= $items->id ?>">

                        <span data-action="mega" class="mega_check"><input name="mega_ch"  type="checkbox" value="2"  <?php if ($items->mega == "YES") {
                    echo "checked";
                } ?>/>منوی مگا</span>
                        
                        <button data-action="delete" style="display: inline-block;">Col2lapse</button>
                        <div class="dd-handle"><?= get_item_name($items->id, $post_array, $cat_array, $product_cat_array) ?>

                        </div>
    <?php
    if ($items->children) {
        ?><ol class="dd-list"><?php foreach ($items->children as $child) { ?>

                                    <li class="dd-item" data-id="<?= $child->id ?>">

                                                 
                                        
                                        <button data-action="delete" style="display: inline-block;">Col2lapse</button>
                                        <div class="dd-handle"><?= get_item_name($child->id, $post_array, $cat_array, $product_cat_array) ?>

                                        </div>
            <?php if ($child->children) { ?>
                                            <ol class="dd-list"><?php foreach ($child->children as $child_3th) { ?>
                                                    <li class="dd-item" data-id="<?= $child_3th->id ?>">
                                                        
                                               
                                                        
                                                        <button data-action="delete" style="display: inline-block;">Col2lapse</button>
                                                        <div class="dd-handle"><?= get_item_name($child_3th->id, $post_array, $cat_array, $product_cat_array) ?>

                                                        </div>

                                                    </li>

                                        <?php } ?></ol><?php }
                                    ?>

                                    </li>

        <?php } ?>
                            </ol><?php
                    }
                    ?>

                    </li>
    <?php
}
?> ----



<?php
foreach (Post::find()->where('menu_show=1')->andWhere(['not in', 'id', $post_array])->all() as $post) {
    ?>
                    <li class="dd-item" data-id="p-<?= $post->id; ?>">
                        <div class="dd-handle"><?= $post->title; ?>

                        </div>
                    </li>
                    <?php
                }
                ?>
<?php
foreach (Category::find()->where('menu_show=1')->andWhere(['not in', 'id', $cat_array])->all() as $cats) {
    ?>
                    <li class="dd-item" data-id="c-<?= $cats->id; ?>">
                        <div class="dd-handle"><?= $cats->name; ?></div>
                    </li>
                    <?php
                }
                ?>

<?php
foreach (common\models\ProductCategory::find()->where('menu_show=1')->andWhere(['not in', 'id', $product_cat_array])->all() as $p_cats) {
    ?>
                    <li class="dd-item" data-id="x-<?= $p_cats->id; ?>">
                        <div class="dd-handle"><?= $p_cats->name; ?></div>
                    </li>
    <?php
}
?>



            </ol>
        </div>



    </div>
    <div class="">
<?php $form = ActiveForm::begin(); ?>


        <textarea id="nestable-output" name="menu_items" style="" ></textarea>
        <br>

        <div style="clear: both;"></div>

        <input type="submit" class="btn success" value="ذخیره" />

<?php ActiveForm::end(); ?>
    </div>
    <script>
        $(document).ready(function ()
        {


            $('span[data-action="mega"]').click(function () {
                console.log("X");
                $("#nestable").trigger("change");
            });
            $('span[data-action="thumb"]').click(function () {
                console.log("THUMB");
                $("#nestable").trigger("change");
            });

            $('button[data-action="delete"]').click(function () {

                console.log('index.php?r=site/remove_from_menu&id=' + $(this).parent().data('id'));


                $.ajax({
                    type: 'GET',
                    url: 'index.php?r=site/remove_from_menu&id=' + $(this).parent().data('id'),
                    crossDomain: true,
                    success: function (output) {

                        if (output.flag == 1) {



                        }

                    },

                    contentType: 'application/json; charset=utf-8',
                    dataType: 'json'
                });



                $(this).parent().remove();

                $("#nestable").trigger("change");

            });
            var updateOutput = function (e)
            {

                var list = e.length ? e : $(e.target),
                        output = list.data('output');
                console.log(e);
                if (window.JSON) {
                    if (output) {
                        output.val(window.JSON.stringify(list.nestable('serialize')));
                    }
                    //

                    //console.log(list.nestable('serialize'));
                    // console.log(window.JSON.stringify(list.nestable('serialize')));
                } else {
                    output.val('JSON browser support required for this demo.');
                }

            };

            // activate Nestable for list 1
            $('#nestable').nestable({
                group: 1,
                maxDepth: 3,
            })
                    .on('change', updateOutput);


            // output initial serialised data
            updateOutput($('#nestable').data('output', $('#nestable-output')));

            $('#nestable-menu').on('click', function (e)
            {
                var target = $(e.target),
                        action = target.data('action');
                if (action === 'expand-all') {
                    $('.dd').nestable('expandAll');
                }
                if (action === 'collapse-all') {
                    $('.dd').nestable('collapseAll');
                }
            });



        });
    </script>
</body>
</html>
