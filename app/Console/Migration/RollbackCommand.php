<?php

namespace App\Console\Migration;

use App\Library\Venture;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Database\Console\Migrations\RollbackCommand as BaseRollbackCommand;

class RollbackCommand extends BaseRollbackCommand
{
    use MigrationTrait;

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        if ($this->option('all')) {
            $this->runFor(Venture::ALL_VENTURES);
        } elseif ($schemas = $this->option('schema')) {
            $this->runFor($this->getValidSchemas($schemas));
        } else {
            parent::handle();
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getOptions()
    {
        $options = parent::getOptions();

        array_push($options,
            ['all', null, InputOption::VALUE_NONE, 'Rollback migrations from all available schemas.'],
            ['schema', null, InputOption::VALUE_OPTIONAL, 'Rollback migrations from given schemas.']
        );

        return $options;
    }
}
