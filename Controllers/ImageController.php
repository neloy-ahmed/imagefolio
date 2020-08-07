<?php
class ImageController extends Controller
{
    
    public function index()
    {
        require(ROOT . 'Models/Image.php');

        $image = new Image();

        $data['images'] = $image->showAllImages();
        $this->set($data);
        $this->render("image_index");
    }
    public function filterOrCrop($image_id, $page)
    {
        
        require(ROOT . 'Models/Image.php');

        $image = new Image();

        $data['image'] = $image->showOneImage($image_id);
        $this->set($data);
        $this->render("$page");
    }

    public function create()
    {

     

        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {

            // Form validation

            $validation_rules = [
                [
                    'fieldName' => 'image',
                    'type' => 'valid_file_type',
                    'required' => true,
                ]
            ];

            require(ROOT . 'Data_Cleaning/Validator.php');
            $validator = new Validator();
            $is_valid = $validator->validate($validation_rules, $_FILES);
            if(!$is_valid){

                $data['success'] = false;
                $data['errors']  = $validator->errors;

                $this->set($data);
                $this->render("image_create");

            }else{

              require(ROOT . 'Models/Image.php');

              $image = new Image();

              

              
              
            $fileData = pathinfo(basename($_FILES["image"]["name"]));

            $fileName = uniqid() . '.' . $fileData['extension'];  
            
            $target_path = (ROOT . 'gallery/' . $fileName);

            while(file_exists($target_path))
            {
                $fileName = uniqid() . '.' . $fileData['extension'];
                $target_path = (ROOT . 'gallery/' . $fileName);
            }

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_path))
            {   
                $form_fields = array('image' => $fileName);
                $image->create($form_fields);


            }



            header("Location: " . WEBROOT . "image/index");

            }

          
            
        }else{

          //Show the form
          $data['page'] = "image_create";
          $this->set($data);

          $this->render("image_create");
        }


    }


    public function applyFilter($image_id, $filter){
        $filter_arr = [
            'grayscale'=> IMG_FILTER_GRAYSCALE,
            'invert'=> IMG_FILTER_NEGATE,
        
        ];
        require(ROOT . 'Models/Image.php');

        $image = new Image();
        
        $this_image = $image->showOneImage($image_id);
        $original_image = $this_image['file_name'];
        $edited_image = "Edited_". $original_image;

        if($filter == 'original'){
            if(file_exists($edited_image)){
                unlink(WEBROOT.'gallery/'.$edited_image);
            }

            return;
        }
        

        $original_image_path = '../gallery/'.$original_image;
        $edited_image_path = '../gallery/'.$edited_image;
        
        copy($original_image_path, $edited_image_path);

        $tmp= explode(".", $edited_image);
        $extension=end($tmp);

        if($extension == 'jpg' || $extension == 'jpeg'){
            $im = imagecreatefromjpeg($edited_image_path);
            if(array_key_exists ( $filter , $filter_arr )){
                imagefilter($im, $filter_arr[$filter]);
            }else{
                if($filter == 'sepia'){
                    imagefilter($im, IMG_FILTER_GRAYSCALE); imagefilter($im, IMG_FILTER_COLORIZE, 90, 60, 40);
                }
            }
            
            imagejpeg($im, $edited_image_path);
            
        }elseif($extension == 'png'){
            $im = imagecreatefrompng($edited_image_path);
            if(array_key_exists ( $filter , $filter_arr )){
                imagefilter($im, $filter_arr[$filter]);
            }else{
                if($filter == 'sepia'){
                    imagefilter($im, IMG_FILTER_GRAYSCALE); imagefilter($im, IMG_FILTER_COLORIZE, 90, 60, 40);
                }
            }
            
            imagepng($im, $edited_image_path);
        }elseif($extension == 'bmp'){
            $im = imagecreatefrombmp($edited_image_path);
            if(array_key_exists ( $filter , $filter_arr )){
                imagefilter($im, $filter_arr[$filter]);
            }else{
                if($filter == 'sepia'){
                    imagefilter($im, IMG_FILTER_GRAYSCALE); imagefilter($im, IMG_FILTER_COLORIZE, 90, 60, 40);
                }
            }
            imagebmp($im, $edited_image_path);
        }

        imagedestroy($im);
    }

    public function flip($image_id, $flip_type){
        $flip_type_arr = [
            // 'none'=> "none",
            'horizontal'=> IMG_FLIP_HORIZONTAL,
            'vertical'=> IMG_FLIP_VERTICAL,
        
        ];


        require(ROOT . 'Models/Image.php');

        $image = new Image();
        
        $this_image = $image->showOneImage($image_id);
        $original_image = $this_image['file_name'];
        $edited_image = "Edited_". $original_image;

        $original_image_path = '../gallery/'.$original_image;
        $edited_image_path = '../gallery/'.$edited_image;
        
        //Copy an edit version of original file if dose not exists
        if(!file_exists($edited_image_path)){
            copy($original_image_path, $edited_image_path);
        }

        $tmp= explode(".", $edited_image);
        $extension=end($tmp);

        if($extension == 'jpg' || $extension == 'jpeg'){
            $im = imagecreatefromjpeg($edited_image_path);
            if(array_key_exists ( $flip_type , $flip_type_arr )){
                imageflip($im, $flip_type_arr[$flip_type]);
            }else{
                return;
            }
            
            imagejpeg($im, $edited_image_path);
            
        }elseif($extension == 'png'){
            $im = imagecreatefrompng($edited_image_path);
            if(array_key_exists ( $flip_type , $flip_type_arr )){
                imageflip($im, $flip_type_arr[$flip_type]);
            }else{
                // if($flip_type == 'none'){
                //     imagerotate($im, 0, 0);
                // }
                return;
            }
            
            imagepng($im, $edited_image_path);
        }elseif($extension == 'bmp'){
            $im = imagecreatefrombmp($edited_image_path);
            if(array_key_exists ( $flip_type , $flip_type_arr )){
                imageflip($im, $flip_type_arr[$flip_type]);
            }else{
                // if($flip_type == 'none'){
                //     imagerotate($im, 0, 0);
                // }
                return;
            }
            imagebmp($im, $edited_image_path);
        }

        imagedestroy($im);
        

    }
    
    public function rotate($image_id, $degree){
        

        require(ROOT . 'Models/Image.php');

        $image = new Image();
        
        $this_image = $image->showOneImage($image_id);
        $original_image = $this_image['file_name'];
        $edited_image = "Edited_". $original_image;

        $original_image_path = '../gallery/'.$original_image;
        $edited_image_path = '../gallery/'.$edited_image;
        
        //Copy an edit version of original file if dose not exists
        if(!file_exists($edited_image_path)){
            copy($original_image_path, $edited_image_path);
        }

        $tmp= explode(".", $edited_image);
        $extension=end($tmp);

        if($extension == 'jpg' || $extension == 'jpeg'){
            $im = imagecreatefromjpeg($edited_image_path);
            $rotate = imagerotate($im, $degree, 0);                       
            imagejpeg($rotate, $edited_image_path);
            
        }elseif($extension == 'png'){
            $im = imagecreatefrompng($edited_image_path);
            $rotate = imagerotate($im, $degree, 0);            
            imagepng($rotate, $edited_image_path);
        }elseif($extension == 'bmp'){
            $im = imagecreatefrombmp($edited_image_path);
            $rotate = imagerotate($im, $degree, 0);
            imagebmp($rotate, $edited_image_path);
        }

        imagedestroy($im);
        imagedestroy($rotate);
        

    }









}
?>
