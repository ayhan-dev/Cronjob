<?php
//class cronjob

/**
** Add cronJob 
** dev @ayhan_dev
** php 8.0
** github.com/ayhan-dev
** t.me/Galaxy_deve
**/
class CronJob {
    private $command;
    private $frequency;
    private $outputFile;
    
    public function __construct($command, $frequency, $outputFile = null) {
        $this->command = $command;
        $this->frequency = $frequency;
        $this->outputFile = $outputFile;
    }
    
    public function create() {
        $cronTab = shell_exec('crontab -l');
        $cronTab .= "\n" . $this->frequency . " " . $this->command . " > " . $this->outputFile . "\n";
        file_put_contents('/tmp/crontab.txt', $cronTab);
        shell_exec('crontab /tmp/crontab.txt');
    }

    public function delete() {
        $cronTab = shell_exec('crontab -l');
        $cronTab = str_replace($this->frequency." ".$this->command." > ".$this->outputFile."\n","",$cronTab);
        if ($cronTab !== false) {
            file_put_contents('/tmp/crontab.txt', $cronTab);
            shell_exec('crontab /tmp/crontab.txt');
        }
    }
}


$cronJob = new CronJob('php /home/ayhandev/public_html/Botsa/API/Test.php','* * * * *','/tmp/output.txt');
$cronJob->create();
