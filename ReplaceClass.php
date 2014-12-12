<?php 
 ////
 //PHP 5.3 + Class find and replace string in files
 //
 //by Bruce Afruz 
 //
 //2013
 //
 //example usage for single file:
 //
 //$new = new fileReplacement('./');
 //$new->setExt("check.php");
 //$new->changeContents("hello", "goodbye");
 //
 //example usage for multiple files:
 //
 //$new = new fileReplacement('./test');
 //$new->setExt("*.html");
 //$new->changeContents("hello", "goodbye");
 //
 //to change directory:
 //
 //$new = new fileReplacement('./test');
 //$new->setDir("./test2");
 //$new->setExt("*.html");
 //$new->changeContents("hello", "goodbye");
 ////


 class fileReplacement 
 {
  private $ext , $dir ;
  public function getDir() {
   return $this->dir;
  }
  public function setDir($dir) {
   $this->dir = $dir;
  }
   public function getExt() {
   return $this->ext;
  }
  public function setExt($ext) {
   $this->ext = $ext;
  }
 function __construct($dir) {
   $this->dir = $dir;
  }

  public function rglob($pattern = '*', $flags = 0, $path = '') {

  chdir($this->getDir());
  $paths = glob($path . '*', GLOB_MARK | GLOB_ONLYDIR | GLOB_NOSORT);
  $files = glob($path . $pattern, $flags);
  foreach ($paths as $path) {
  $files = array_merge($files, $this->rglob($pattern, $flags, $path));
  }
  return $files;
 }

 public function changeContents($replace , $sentence , $flags = 0, $path = '') {
 $all = $this->rglob($this->getExt() , $flags, $path);
 foreach ($all as $file) {

  $filename = $file;
  $handle = fopen($filename, "r");
  $contents = fread($handle, filesize($filename));
  fclose($handle);
  $contents = str_replace($replace , $sentence, $contents);

  if (is_writable($filename)) {
   if (!$handle = fopen($filename, 'w+')) {
    echo "Cannot open file ($filename)
";
    exit;
   }

   // Write $contents to our opened file.
   if (fwrite($handle, $contents) === FALSE) {
    echo "Cannot write to file ($filename)
";
    exit;
   }

   echo "Success, wrote content to file ($filename)
";

   fclose($handle);
  } else {
   echo "The file $filename is not writable
";
  }
 }
 }}
?>