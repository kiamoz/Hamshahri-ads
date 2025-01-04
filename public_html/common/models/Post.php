<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

class Post extends \yii\db\ActiveRecord {

    public $top_date_farsi, $org_date, $date_farsi;
    public $cat, $file;
    public $time_create;
    public $datefarsi;
    public $video_file,$category,$tag,$post_cat;

    public static function tableName() {
        return 'post';
    }

    public function rules() {
        return [
                [['body'], 'string'],
                [['date', 'file', 'link', 'slug', 'summery', 'menu_show', 'index_status', 'video', 'is_video', 'is_gallery', 'is_index_content','category','title2','tag','post_cat'], 'safe'],
                [['title'], 'string', 'max' => 1000],
                [['file_path'], 'string', 'max' => 2000],
                [['thumb_nail'], 'string', 'max' => 200],
                [['file'], 'file']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'شناسه',
            'title' => 'عنوان',
            'title2'=>'عنوان دوم',
            'body' => 'توضیحات',
            'date' => 'تاریخ',
            'file_path' => 'مسیر فایل',
            'thumb_nail' => 'تصویر',
            'video_file' => 'ویدئو',
            'summery' => 'خلاصه',
            'file' => 'تصویر',
            'link' => 'لینک',
            'show_menu' => 'وضعیت',
            'is_video' => 'ویدئو'
        ];
    }

    public static function compare_2_array($input, $source) {
        foreach ($input as $v) {
            if (in_array($v, $source)) {
                return true;
            }
        }
        return FALSE;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostHasCategories() {
        return $this->hasMany(PostHasCategory::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories() {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable('post_has_category', ['post_id' => 'id']);
    }

    public static function resize_img($path, $w, $h, $name) {

       

        $path_dist = dirname(dirname((dirname(__FILE__)))) . "/frontend/web/";
     
        
       
        
        $retur_name = "_px_" . $name . $w . $h . 'm.jpg';
        
       
        try {
            

            
            if (!file_exists($path_dist . 'upload3/'. $retur_name)) {

                
                if (file_exists($path)) {
                 
                    Post::resize_crop_image($w, $h, $path, 'upload3/' . $retur_name);
                } else {
                    return 0;
                }
            }

            return  '/frontend/web/upload3/' . $retur_name;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public static function arabic_w2e($str) {
        $arabic_eastern = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
        $arabic_western = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        return str_replace($arabic_western, $arabic_eastern, $str);
    }

    public static function getPostHumanTime($id) {
        $m = Post::findOne($id);
        date_default_timezone_set('Asia/Tehran');
        $time = strtotime($m->time);



        return Post::humanTiming($time);
    }

    public static function humanTiming($time) {

        date_default_timezone_set('Asia/Tehran');
        //echo date('d M Y H:i:s',time());
        //exit();
        //echo time()."---". $time;
        //exit();
        $time = time() - $time; // to get the time since that moment
        $time = ($time < 1) ? 1 : $time;
        $tokens = array(
            31536000 => 'سال ',
            2592000 => 'ماه ',
            604800 => 'هفته ',
            86400 => 'روز ',
            3600 => 'ساعت ',
            60 => ' دقیقه',
            1 => 'ثانیه '
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit)
                continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? '' : '');
        }
    }

    public static function resize_crop_image($max_width, $max_height, $source_file, $dst_dir, $quality = 80) {
        $imgsize = getimagesize($source_file);
        $width = $imgsize[0];
        $height = $imgsize[1];
        $mime = $imgsize['mime'];

        switch ($mime) {
            case 'image/gif':
                $image_create = "imagecreatefromgif";
                $image = "imagegif";
                break;

            case 'image/png':
                $image_create = "imagecreatefrompng";
                $image = "imagepng";
                $quality = 7;
                break;

            case 'image/jpeg':
                $image_create = "imagecreatefromjpeg";
                $image = "imagejpeg";
                $quality = 80;
                break;

            default:
                return false;
                break;
        }

        $dst_img = imagecreatetruecolor($max_width, $max_height);
        $src_img = $image_create($source_file);

        $width_new = $height * $max_width / $max_height;
        $height_new = $width * $max_height / $max_width;
        //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
        if ($width_new > $width) {
            //cut point by height
            $h_point = (($height - $height_new) / 2);
            //copy image
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
        } else {
            //cut point by width
            $w_point = (($width - $width_new) / 2);
            imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
        }

        $image($dst_img, $dst_dir, $quality);

        if ($dst_img)
            imagedestroy($dst_img);
        if ($src_img)
            imagedestroy($src_img);
    }

    public static function getpostCats($id) {




        if (Post::find()->where(['id' => $id])->exists()) {
            $category_arr = array();
            $m = \common\models\PostHasCategory::find()->
                            with('post')->
                            where('post_id=' . $id)->all();
            foreach ($m as $cats) {
                array_push($category_arr, $cats->category_id);
            }
            return $category_arr;
        }
    }

    public static function getpostCatsName($id) {

        $list = "";
        $arr = Post::getpostCats($id);

        foreach ($arr as $cats) {
            $list .= "-" . Category::getCatName($cats);
        }
        return $list;
    }

    public static function limitword($string, $limit) {
        $words = explode(" ", $string);

        $output = implode(" ", array_splice($words, 0, $limit));
        return $output;
    }

    public static function getPost_view_count($id) {

        return PostView::find()->where('post_id=' . $id)->count();
    }

    public function afterFind() {

        parent::afterFind();

        
        $this->datefarsi = Persian::convert_date_to_fa($this->date, TRUE);
    }



    public static function getPostId($slug) {

        return Post::find()->where('slug="' . $slug . '"')->One()->id;
    }
    public static function getPost_cat_Id($slug) {

        return Category::find()->where('slug="' . $slug . '"')->One()->id;
    }

    public static function getSlug($title) {
        $title = str_replace('&#8204;', '*', $title);
        $title = str_replace('‌', '-', $title);
        $title = str_replace(' ً', '-', $title);
        $title = str_replace('ئٍ', '-', $title);
        $title = str_replace("ئ", "", $title);
        $title = str_replace('ُ', '', $title);
        $title = str_replace('ِ', '', $title);
        $title = str_replace('اً', '-', $title);
        $title = str_replace(' ', '-', $title);
        $title = str_replace('&zwnj;', '*', $title);
        $title = str_replace("\xE2\x80\x8B", "", $title);
        $title = str_replace(":", "", $title);
        $title = str_replace("»", "", $title);
        $title = str_replace('"', "", $title);
        $title = str_replace("«", "", $title);
        $title = str_replace(".", "", $title);
        $title = str_replace("!", "", $title);
        $title = str_replace("؟", "", $title);
        $title = str_replace("؟", "", $title);
        $title = str_replace("؟", "", $title);
        $title = str_replace("،", "", $title);
        $title = str_replace("?", "", $title);
        $title = str_replace("(", "-", $title);
        $title = str_replace(")", "-", $title);
        $title = str_replace(" ", "-", $title);
        $title = str_replace("؛", "", $title);

        $title = str_replace("/", "-", $title);
        $title = str_replace("+", "-", $title);
        $title = str_replace("--", "-", $title);
        $title = str_replace("---", "-", $title);
        $title = str_replace("'", "-", $title);
        $title = str_replace('"', "-", $title);
        $title = str_replace('“', "-", $title);

//        $same_id = Post::getPostId($title);
//        if ($same_id > 0) {
//            $title.=$same_id;
//        }
        return $post_id . $title;
    }

    public static function get_tag_name_and_id($id) {
        if ($id) {
            $tags_name = array();
            $tags_id = array();
            $return_array = array();
            $post_tags = PostHasTag::find()
                            ->with('tag')
                            ->where('post_id=' . $id)->all();
            foreach ($post_tags as $post_tag) {

                $return_array[$post_tag->tag->id] = $post_tag->tag->name;
            }

            return $return_array;
        }
    }

    public function getPosthas() {
        return $this->hasOne(PostHasCategory::className(), ['post_id' => 'id']);
    }

    public static function related_posts($id,$limit=3) {

        $cats_ar = Post::getpostCats($id);
       

        return PostHasCategory::find()->innerJoinWith('post')->where(['category_id' => $cats_ar])->andWhere(['!=','id',$id])->limit($limit)->all();
    }

    public static function get_cats_id_and_name($id) {
        if ($id) {
            $cats_name = array();
            $cats_id = array();
            $return_array = array();
            $post_cats = PostHasCategory::find()
                            ->with('category')
                            ->where('post_id=' . $id)->all();
            foreach ($post_cats as $post_cat) {

                $return_array[$post_cat->category->id] = $post_cat->category->name;
            }

            return $return_array;
        }
    }
    
      public function getPosthasCategory() {
        return $this->hasOne(PostHasCategory::className(), ['post_id' => 'id']);
    }

    
     

}
