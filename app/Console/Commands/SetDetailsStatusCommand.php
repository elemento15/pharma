<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use App\PurchaseOrder;
use App\Status;

class SetDetailsStatusCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'command:set_details_status';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Get all purchase orders without status and set it to New.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->info('Initiating Process...');

		// get the default status for Purchase Orders (type = PO)
		$status = Status::where('type', 'PO')->where('is_default', 1)->first();

		if (! $status) {
			$this->error('Could not find status needed');
		} else {
			$orders = PurchaseOrder::where('status_id', NULL)->get();
			
			foreach ($orders as $item) {
				$item->status_id = $status->id;
				$item->save();
			}

			$this->info('Process Terminated');
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			//['example', InputArgument::REQUIRED, 'An example argument.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			//['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		];
	}

}
