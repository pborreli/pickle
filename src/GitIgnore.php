<?php
namespace Pickle;

trait GitIgnore
{
    /**
     *
     * Get the gitignore files
     *
     * @return array
     *
     */
    public function getGitIgnoreFiles()
    {
        $file = $this->path . "/.gitignore";
        $dir = $this->path;
        $matches = array();
        $lines = file($file);

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;                 # empty line
            }
            if (substr($line, 0, 1) == '#') {
                continue;   # a comment
            }
            if (substr($line, 0, 1)== '!') {           # negated glob
                $line = substr($line, 1);
                $files = array_diff(glob("$dir/*"), glob("$dir/$line"));
            } else {                                    # normal glob
                $files = glob("$dir/$line");
            }
            $matches = array_merge($matches, $files);
        }

        return $matches;
    }
}
