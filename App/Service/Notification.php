<?php
namespace Service;

class Notification
{
	private $flash = [];

	function setFlash ($message, $type = 'danger')
	{
		$this->flash = [
			'message' 	=> $message,
			'type'		=> $type
		];
	}

	function flash ()
	{
		if (!empty($this->flash)) {
            ?>
            <div id="alert" class="alert alert-<?php echo $this->flash['type'] ?> text-center" role="alert">
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           
                <strong><?php print_r($this->flash['message']); ?></strong>
            </div>
            <?php
            unset($this->flash);
		}
	}
}