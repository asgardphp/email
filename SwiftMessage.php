<?php
namespace Asgard\Email;

class SwiftMessage extends \Swift_Message {
	public function subject($subject) {
		return parent::setSubject($subject);
	}

	public function to($to) {
		return parent::setTo($to);
	}

	public function from($from) {
		return parent::setFrom($from);
	}

	public function cc($cc) {
		return parent::setCc($cc);
	}

	public function bcc($bcc) {
		return parent::setBcc($bcc);
	}

	public function html($html) {
		return parent::addPart($html, 'text/html');
	}

	public function text($text) {
		return parent::addPart($text, 'text/plain');
	}

	public function htmlView($view, $data=array()) {
		$data['message'] = $this;
		$res = $this->buildView($view, $data);
		return $this->html($res);
	}

	public function textView($view, $data=array()) {
		$data['message'] = $this;
		$res = $this->buildView($view, $data);
		return $this->text($res);
	}

	protected function buildView($_file, $_data) {
		foreach($_data as $_k=>$_v)
			$$_k = $_v;
		ob_start();
		include $_file;
		return ob_get_clean();
	}

	public function attachFile($file, $options=array()) {
		$attachment = \Swift_Attachment::fromPath($file);
		if(isset($options['filename']))
			$attachment->setFilename($options['filename']);
		if(isset($options['mime']))
			$attachment->setContentType($options['mime']);
		return parent::attach($attachment);
	}

	public function attachData($data, $options=array()) {
		$attachment = \Swift_Attachment::newInstance($data);
		if(isset($options['filename']))
			$attachment->setFilename($options['filename']);
		if(isset($options['mime']))
			$attachment->setContentType($options['mime']);
		return parent::attach($attachment);
	}

	public function embedFile($file, $options=array()) {
		$image = \Swift_Image::fromPath($file);
		if(isset($options['filename']))
			$image->setFilename($options['filename']);
		if(isset($options['mime']))
			$image->setContentType($options['mime']);
		return parent::embed($image);
	}

	public function embedData($data, $options=array()) {
		$image = \Swift_Image::newInstance($data);
		if(isset($options['filename']))
			$image->setFilename($options['filename']);
		if(isset($options['mime']))
			$image->setContentType($options['mime']);
		return parent::embed($image);
	}
}