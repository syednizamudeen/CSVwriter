# CSVwriter

CSV Writer with UTF-8 and null enclosures
#### Usage
Simplified
```bash
$csv = new CSVwriter('php://output');
$csv->save( array( array('Monday', 'Tuesday', 'Wednesday'), array('Thursday','Friday') ) );
```
