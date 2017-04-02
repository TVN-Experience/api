Visit the below endpoints<br/>
<br/>
Get all Apartments:<br/>
https://project.cmi.hr.nl/2016_2017/bcp_mt3b_t2/api/apartments/<br/>
Method: GET<br/>
<br/>
Get all Apartments by type:<br/>
https://project.cmi.hr.nl/2016_2017/bcp_mt3b_t2/api/apartments/type/$type_id<br/>
Method: GET<br/>
<br/>
Get Apartment by id:<br/>
https://project.cmi.hr.nl/2016_2017/bcp_mt3b_t2/api/apartments/id/$id<br/>
Method: GET<br/>
<br/>
Add a Apartment:<br/>
https://project.cmi.hr.nl/2016_2017/bcp_mt3b_t2/api/apartments/<br/>
Method: POST<br/>
Parameters:<br/>
- type_id<br/>
- measurements<br/>
- description<br/>
- floors<br/>
<br/>
Get all Types:<br/>
https://project.cmi.hr.nl/2016_2017/bcp_mt3b_t2/api/types/<br/>
Method: GET<br/>
<br/>
Get a specific Type:<br/>
https://project.cmi.hr.nl/2016_2017/bcp_mt3b_t2/api/types/$type_id<br/>
Method: GET<br/>
<br/>
Add a Type:<br/>
https://project.cmi.hr.nl/2016_2017/bcp_mt3b_t2/api/types/<br/>
Method: POST<br/>
Parameters:<br/>
- type<br/>
- description<br/>
<br/>
Get all Beacons:<br/>
https://project.cmi.hr.nl/2016_2017/bcp_mt3b_t2/api/apartment/beacons/<br/>
Method: GET<br/>
<br/>
Get a Beacon:<br/>
https://project.cmi.hr.nl/2016_2017/bcp_mt3b_t2/api/apartment/beacons/$id<br/>
Method: GET<br/>
<br/>
Add a Beacon:<br/>
https://project.cmi.hr.nl/2016_2017/bcp_mt3b_t2/api/beacons/<br/>
Method: POST<br/>
Parameters:<br/>
- apartment_id<br/>
- description<br/>
<br/>