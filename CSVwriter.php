<?php
class CSVwriter
{
	private $filename;
	private $mode;
	private $delimiter	= ',';
	private $enclosure	= '"';
	private $lineEnding = PHP_EOL;
	private $useBOM = FALSE;
	private $escape = '?';
	
	public function __construct( $value = NULL, $attr='wb+' )
	{
		$this->filename = $value;
		$this->mode = $attr;
	}
	public function save( $rows )
	{
		$fileHandle = fopen( $this->filename, $this->mode );
		if ($fileHandle === FALSE) {
			error_log( print_r( 'Could not open file for writing.', 1 ), 0 );
		}
		if ( $this->useBOM )
		{
			fwrite($fileHandle, "\xEF\xBB\xBF");	//	Enforce UTF-8 BOM Header
		}
		if( is_array($rows) && !empty($rows) )
		{
			foreach( $rows as $k => $v )
			{
				$this->writeLine( $fileHandle, $v );
			}
		}
		fclose($fileHandle);
	}
	private function writeLine( $fileHandle, $value )
	{
		if( is_array( $value ) )
		{
			$writerow = $this->escapedimplode( $value );
			if( is_string( $writerow ) && !empty( $writerow ) )
			{
				fwrite($fileHandle, $writerow.$this->lineEnding );
			}
		}
		else
		{
			error_log( print_r( 'Invalid data row passed to CSV writer.', 1 ), 0 );
		}
	}
	public function getUseBOM()
	{
		return $this->useBOM;
	}
	public function setUseBOM( $value = FALSE )
	{
		$this->useBOM = $value;
		return $this;
	}
	public function getLineEnding()
	{
		return $this->lineEnding;
	}
	public function setLineEnding( $value = PHP_EOL )
	{
		$this->lineEnding = $value;
		return $this;
	}
	public function getEnclosure()
	{
		return $this->enclosure;
	}
	public function setEnclosure( $value = '"' )
	{
		if ($value == '')
		{
			$value = null;
		}
		$this->enclosure = $value;
		return $this;
	}
	public function getDelimiter()
	{
		return $this->delimiter;
	}
	public function setDelimiter( $value = ',' )
	{
		$this->delimiter = $value;
		return $this;
	}
	public function getEscape()
	{
		return $this->escape;
	}
	public function setEscape( $value = '?' )
	{
		$this->escape = $value;
		return $this;
	}
	private function escapedimplode( $arr )
	{
		if (!is_array($arr))
		{
			return FALSE;
		}
		foreach ($arr as $k => $v)
		{
			$arr[$k] = str_replace( $this->delimiter, $this->escape . $this->delimiter, $v );
		}
		return implode($this->delimiter, $arr);
	}
}
?>