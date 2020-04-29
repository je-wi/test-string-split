<?php
/*
    Universität Leipzig, Lehrstuhl für Alte Geschichte, Leipzig 2020  
    # GPLv3 copyrigth
    # This program is free software: you can redistribute it and/or modify
    # it under the terms of the GNU General Public License as published by
    # the Free Software Foundation, either version 3 of the License, or
    # (at your option) any later version.
    # This program is distributed in the hope that it will be useful,
    # but WITHOUT ANY WARRANTY; without even the implied warranty of
    # MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    # GNU General Public License for more details.
    # You should have received a copy of the GNU General Public License
    # along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/


# testing the speed of splitting decomposed Multibyte Strings into an array
# the file structure of the testing files
/*
tlg_tok_tsv/
  0001/
    0001-001.tsv
    0001-002.tsv
    0001-003.tsv
  0002/
    0002-001.tsv
    0002-002.tsv 
    0002-003.tsv
    0002-004.tsv      
*/


/*------------------------------------------------------------------------------
                     starts here
------------------------------------------------------------------------------*/
mb_internal_encoding("UTF-8");
mb_regex_encoding('UTF-8');
error_reporting(-1);
$time_start = microtime(true);

$dir2senPR = 'tlg_tok_tsv/';
$dirs = readDirFolder($dir2senPR);
foreach($dirs as $aid)
  {
  $files = readDocFolder($dir2senPR.$aid);
  $tsvfiles[$aid] = $files;
  }
  

$allworks = array();
foreach( $tsvfiles as $aid=>$files )
  {
  $z = count($files);
  for($i=0;$i<$z;$i++)
    {
    $author_work = str_replace(".tsv","",$files[$i]);
    $lines = load_tabbed_file($dir2senPR.$aid."/".$files[$i], $load_keys=false);
    foreach($lines as $index=>$line)
      {
      # in case some of the files arent correct rewritten we ignore the line
      if( count($line) == 2 )
        {
        $line[1] = transliterator_transliterate("NFD;", $line[1]);
        $linearray = array();  
        
# test hier the differences, uncomment one of them

# 0. without splitting: uncomment nothing  

# 1. mb_split_array: helper functions, mb_strlen() and mb_substr()
    
        #$linearray = mb_split_array($line[1]);   

# 2. preg_split: regular expression with negative lookbehind  

        #$linearray = preg_split( '/(?<!^)(?!$)/u', $line[1] );
        
# 3. mb_str_split: PHP >= 7.4 

        #$linearray = mb_str_split($line[1]); # !!! PHP 7.4          

        foreach($linearray as $c)
          {
          # do something with each char
          
          }          
               
        }//end if
      else
        var_dump($line);

      #if($index==100) break;
      }//end foreach

    }//end for

# counts the time for each author cumulative      
file_put_contents('test_mb_string_split.txt','0: '.$aid.' '.(microtime(true)-$time_start)."\r\n",FILE_APPEND);
  
  }//end foreach
$time = microtime(true)-$time_start;
echo "time: ".$time."<br>";

/*------------------------------------------------------------------------------
                     ends here
------------------------------------------------------------------------------*/



/*------------------------------------------------------------------------------
                     some helper functions - begin
------------------------------------------------------------------------------*/
function mb_split_array($str)
  {
  $z = mb_strlen($str);
  $r = array();

  for( $i = 0; $i < $z; $i++)
    {
     $r[] = mb_substr( $str, $i, 1);
    }
  return $r;
  }
  
function readDirFolder($dir)
  {
  $files = scandir($dir);
  $r = array();
  
  if( is_array($files) )
    {
    foreach ($files as $key => $value)
       {
          if ( !in_array($value,array(".","..")) AND is_dir($dir.'/'.$value) )
          {
          $r[] = $value;
          }
       } 
    
    }
  return $r;  
  } 

function readDocFolder($dir)
  {
  $files = scandir($dir);
  $r = array();
  
  if( is_array($files) )
    {
    foreach ($files as $key => $value)
       {
          if ( !in_array($value,array(".","..")) AND !is_dir($dir.'/'.$value) )
          {
          $r[] = $value;
          }
       } 
    
    }
  return $r;  
  }   
  
function load_tabbed_file($filepath, $load_keys=false)
  {
    $array = array();
 
    if (!file_exists($filepath)) return $array;
    $content = file($filepath);
 
    for ($x=0; $x < count($content); $x++)
      {
      if (trim($content[$x]) != '')
        {
          $line = explode("\t", trim($content[$x]));
          if ($load_keys)
            {
            $key = array_shift($line);
            $array[$key] = $line;
            }
          else 
            { 
            $array[] = $line;           
            }
        }
      }
    return $array;
  }  
/*------------------------------------------------------------------------------
                     some helper functions - ends
------------------------------------------------------------------------------*/  

?>