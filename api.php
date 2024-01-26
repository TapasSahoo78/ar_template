Booking
http://166.62.54.122/arcotransbackend/public/index.php/api/booking/user-wise-book-list
{
"user_id": 43
}
{
"status": true,
"message": "Booking List Fetch Successfully!",
"data": [
{
"id": 20,
"user_id": 43,
"bus": {
"id": 2,
"name": "Bus 2",
"vehicle_no": "WB00167",
"route_id": 3,
"from_time": "06:15:00",
"to_time": "07:15:00",
"status": 1
},
"route": {
"id": 2,
"name": "Sandy Beach",
"slug": "sandy-beach",
"status": 1,
"busStop": [
{
"id": 3,
"name": "Ferry terminal",
"slug": "ferry-terminal",
"location": "australia",
"longitude": "153.382429",
"latitude": "-27.646218",
"status": 1
},
{
"id": 4,
"name": "Canaipa",
"slug": "canaipa",
"location": null,
"longitude": "153.381732",
"latitude": "-27.648951",
"status": 1
},
{
"id": 5,
"name": "RI School",
"slug": "ri-school",
"location": null,
"longitude": "153.381304",
"latitude": "-27.651299",
"status": 1
},
{
"id": 6,
"name": "Kings",
"slug": "kings",
"location": null,
"longitude": "153.380953",
"latitude": "-27.653359",
"status": 1
},
{
"id": 7,
"name": "Highland",
"slug": "highland",
"location": null,
"longitude": "153.380467",
"latitude": "-27.655982",
"status": 1
},
{
"id": 8,
"name": "Pharlap",
"slug": "pharlap",
"location": null,
"longitude": "153.379771",
"latitude": "-27.659761",
"status": 1
},
{
"id": 9,
"name": "Elm",
"slug": "elm",
"location": null,
"longitude": "153.379839",
"latitude": "-27.661869",
"status": 1
},
{
"id": 10,
"name": "Skiff",
"slug": "skiff",
"location": null,
"longitude": "153.384505",
"latitude": "-27.662524",
"status": 1
},
{
"id": 11,
"name": "Zircon",
"slug": "zircon",
"location": null,
"longitude": "153.384241",
"latitude": "-27.666659",
"status": 1
},
{
"id": 12,
"name": "Zinnia",
"slug": "zinnia",
"location": null,
"longitude": "153.384529",
"latitude": "-27.672404",
"status": 1
},
{
"id": 13,
"name": "Rose Bay",
"slug": "rose-bay",
"location": null,
"longitude": "153.384533",
"latitude": "-27.679375",
"status": 1
},
{
"id": 14,
"name": "Kurrajong",
"slug": "kurrajong",
"location": null,
"longitude": "153.384017",
"latitude": "-27.682252",
"status": 1
},
{
"id": 15,
"name": "Hume",
"slug": "hume",
"location": null,
"longitude": "153.383697",
"latitude": "-27.686161",
"status": 1
},
{
"id": 16,
"name": "Waikiki",
"slug": "waikiki",
"location": null,
"longitude": "153.383408",
"latitude": "-27.689567",
"status": 1
},
{
"id": 17,
"name": "Kenedy",
"slug": "kenedy",
"location": null,
"longitude": "153.382749",
"latitude": "-27.694463",
"status": 1
},
{
"id": 18,
"name": "Crescent",
"slug": "crescent",
"location": null,
"longitude": "153.382003",
"latitude": "-27.698607",
"status": 1
},
{
"id": 19,
"name": "Glendale",
"slug": "glendale",
"location": null,
"longitude": "153.388349",
"latitude": "-27.699694",
"status": 1
},
{
"id": 20,
"name": "The Tor Walk",
"slug": "the-tor-walk",
"location": null,
"longitude": "153.387248",
"latitude": "-27.703115",
"status": 1
},
{
"id": 21,
"name": "Paradise",
"slug": "paradise",
"location": null,
"longitude": "153.386457",
"latitude": "-27.705429",
"status": 1
},
{
"id": 22,
"name": "Sandy Beach",
"slug": "sandy-beach",
"location": null,
"longitude": "153.389677",
"latitude": "-27.703990",
"status": 1
}
]
},
"longitude": "12.23433567",
"latitude": "65.76544443",
"date": "2023-09-26",
"time": "22:34:00",
"booking_no": "ARCO0000010",
"status": 0
}
]
}

http://166.62.54.122/arcotransbackend/public/index.php/api/route/available-bus

{
"route_id": "3",
"time": "18:37:47" //default current time or user selected time
}
{
"status": true,
"response_code": 200,
"message": "Bus Fetch successfully",
"data": {
"id": 3,
"name": "North",
"slug": "north",
"status": 1,
"created_at": "2023-12-08T01:02:36.000000Z",
"updated_at": "2023-12-08T01:02:36.000000Z",
"deleted_at": null,
"get_bus_stop": [
{
"id": 26,
"route_id": 3,
"name": "Borrows",
"slug": "borrows",
"location": null,
"longitude": "153.381817",
"latitude": "-27.649315",
"status": 1,
"created_at": "2023-12-08T07:00:45.000000Z",
"updated_at": "2023-12-08T07:00:45.000000Z",
"deleted_at": null
},
{
"id": 27,
"route_id": 3,
"name": "Bunning",
"slug": "bunning",
"location": null,
"longitude": "153.383895",
"latitude": "-27.650542",
"status": 1,
"created_at": "2023-12-08T07:01:10.000000Z",
"updated_at": "2023-12-08T07:01:10.000000Z",
"deleted_at": null
},
{
"id": 28,
"route_id": 3,
"name": "Gunthrie",
"slug": "gunthrie",
"location": null,
"longitude": "153.386083",
"latitude": "-27.653134",
"status": 1,
"created_at": "2023-12-08T07:01:27.000000Z",
"updated_at": "2023-12-08T07:01:27.000000Z",
"deleted_at": null
},
{
"id": 29,
"route_id": 3,
"name": "RSL",
"slug": "rsl",
"location": null,
"longitude": "153.388126",
"latitude": "-27.654759",
"status": 1,
"created_at": "2023-12-08T07:01:45.000000Z",
"updated_at": "2023-12-08T07:01:45.000000Z",
"deleted_at": null
},
{
"id": 30,
"route_id": 3,
"name": "Cutter",
"slug": "cutter",
"location": null,
"longitude": "153.386957",
"latitude": "-27.655672",
"status": 1,
"created_at": "2023-12-08T07:04:38.000000Z",
"updated_at": "2023-12-08T07:04:38.000000Z",
"deleted_at": null
},
{
"id": 31,
"route_id": 3,
"name": "Bernborough",
"slug": "bernborough",
"location": null,
"longitude": "153.383581",
"latitude": "-27.657233",
"status": 1,
"created_at": "2023-12-08T07:05:01.000000Z",
"updated_at": "2023-12-08T07:05:01.000000Z",
"deleted_at": null
},
{
"id": 33,
"route_id": 3,
"name": "Regal",
"slug": "regal",
"location": null,
"longitude": "153.375106",
"latitude": "-27.654949",
"status": 1,
"created_at": "2023-12-08T07:06:26.000000Z",
"updated_at": "2023-12-08T07:06:26.000000Z",
"deleted_at": null
},
{
"id": 34,
"route_id": 3,
"name": "Cosmos",
"slug": "cosmos",
"location": null,
"longitude": "153.370257",
"latitude": "-27.653926",
"status": 1,
"created_at": "2023-12-08T07:06:45.000000Z",
"updated_at": "2023-12-08T07:06:45.000000Z",
"deleted_at": null
},
{
"id": 35,
"route_id": 3,
"name": "Satton",
"slug": "satton",
"location": null,
"longitude": "153.372107",
"latitude": "-27.652121",
"status": 1,
"created_at": "2023-12-08T07:07:01.000000Z",
"updated_at": "2023-12-08T07:07:01.000000Z",
"deleted_at": null
},
{
"id": 36,
"route_id": 3,
"name": "Cavendish",
"slug": "cavendish",
"location": null,
"longitude": "153.376973",
"latitude": "-27.648616",
"status": 1,
"created_at": "2023-12-08T07:07:18.000000Z",
"updated_at": "2023-12-08T07:07:18.000000Z",
"deleted_at": null
},
{
"id": 37,
"route_id": 3,
"name": "Jackson",
"slug": "jackson",
"location": null,
"longitude": "153.379254",
"latitude": "-27.660077",
"status": 1,
"created_at": "2023-12-08T07:07:37.000000Z",
"updated_at": "2023-12-08T07:07:37.000000Z",
"deleted_at": null
},
{
"id": 38,
"route_id": 3,
"name": "Bowls Club",
"slug": "bowls-club",
"location": null,
"longitude": "153.373338",
"latitude": "-27.659215",
"status": 1,
"created_at": "2023-12-08T07:08:00.000000Z",
"updated_at": "2023-12-08T07:08:00.000000Z",
"deleted_at": null
},
{
"id": 39,
"route_id": 3,
"name": "Lau",
"slug": "lau",
"location": null,
"longitude": "153.369397",
"latitude": "-27.658655",
"status": 1,
"created_at": "2023-12-08T07:08:20.000000Z",
"updated_at": "2023-12-08T07:08:20.000000Z",
"deleted_at": null
},
{
"id": 40,
"route_id": 3,
"name": "Channel",
"slug": "channel",
"location": null,
"longitude": "153.369171",
"latitude": "-27.660744",
"status": 1,
"created_at": "2023-12-08T07:08:38.000000Z",
"updated_at": "2023-12-08T07:08:38.000000Z",
"deleted_at": null
},
{
"id": 41,
"route_id": 3,
"name": "Forest Hill",
"slug": "forest-hill",
"location": null,
"longitude": "153.372922",
"latitude": "-27.661305",
"status": 1,
"created_at": "2023-12-08T07:08:55.000000Z",
"updated_at": "2023-12-08T07:08:55.000000Z",
"deleted_at": null
},
{
"id": 42,
"route_id": 3,
"name": "Doverton",
"slug": "doverton",
"location": null,
"longitude": "153.378732",
"latitude": "-27.662146",
"status": 1,
"created_at": "2023-12-08T07:09:11.000000Z",
"updated_at": "2023-12-08T07:09:11.000000Z",
"deleted_at": null
}
],
"get_bus": [
{
"id": 2,
"name": "Bus 2",
"vehicle_no": "WB00167",
"route_id": 3,
"from_time": "06:15:00",
"to_time": "07:15:00",
"status": 1,
"created_at": "2023-12-01T16:16:03.000000Z",
"updated_at": "2023-12-01T16:16:03.000000Z",
"deleted_at": null
}
]
}
}



http://166.62.54.122/arcotransbackend/public/index.php/api/driver/assigen-bus-route
{
"user_id":49
}

{
"status": true,
"message": "Driver Find Successfully!",
"data": [
{
"id": 1,
"user_id": 49,
"route_id": null,
"bus_id": 2,
"date": "2023-12-18",
"start_time": "11:50:00",
"end_time": "13:50:00",
"status": 0,
"bus": {
"id": 2,
"name": "Bus 2",
"vehicle_no": "WB00167",
"route_id": 3,
"from_time": "06:15:00",
"to_time": "07:15:00",
"status": 1
},
"user": {
"id": 49,
"name": "Qw",
"phone": "1111111112",
"gender": "male",
"email": "driver@gmail.com",
"url": "http://166.62.54.122/arcotransbackend/public/uploads"
},
"route": {
"id": 3,
"name": "North",
"slug": "north",
"status": 1,
"busStop": [
{
"id": 26,
"name": "Borrows",
"slug": "borrows",
"location": null,
"longitude": "153.381817",
"latitude": "-27.649315",
"status": 1
},
{
"id": 27,
"name": "Bunning",
"slug": "bunning",
"location": null,
"longitude": "153.383895",
"latitude": "-27.650542",
"status": 1
},
{
"id": 28,
"name": "Gunthrie",
"slug": "gunthrie",
"location": null,
"longitude": "153.386083",
"latitude": "-27.653134",
"status": 1
},
{
"id": 29,
"name": "RSL",
"slug": "rsl",
"location": null,
"longitude": "153.388126",
"latitude": "-27.654759",
"status": 1
},
{
"id": 30,
"name": "Cutter",
"slug": "cutter",
"location": null,
"longitude": "153.386957",
"latitude": "-27.655672",
"status": 1
},
{
"id": 31,
"name": "Bernborough",
"slug": "bernborough",
"location": null,
"longitude": "153.383581",
"latitude": "-27.657233",
"status": 1
},
{
"id": 33,
"name": "Regal",
"slug": "regal",
"location": null,
"longitude": "153.375106",
"latitude": "-27.654949",
"status": 1
},
{
"id": 34,
"name": "Cosmos",
"slug": "cosmos",
"location": null,
"longitude": "153.370257",
"latitude": "-27.653926",
"status": 1
},
{
"id": 35,
"name": "Satton",
"slug": "satton",
"location": null,
"longitude": "153.372107",
"latitude": "-27.652121",
"status": 1
},
{
"id": 36,
"name": "Cavendish",
"slug": "cavendish",
"location": null,
"longitude": "153.376973",
"latitude": "-27.648616",
"status": 1
},
{
"id": 37,
"name": "Jackson",
"slug": "jackson",
"location": null,
"longitude": "153.379254",
"latitude": "-27.660077",
"status": 1
},
{
"id": 38,
"name": "Bowls Club",
"slug": "bowls-club",
"location": null,
"longitude": "153.373338",
"latitude": "-27.659215",
"status": 1
},
{
"id": 39,
"name": "Lau",
"slug": "lau",
"location": null,
"longitude": "153.369397",
"latitude": "-27.658655",
"status": 1
},
{
"id": 40,
"name": "Channel",
"slug": "channel",
"location": null,
"longitude": "153.369171",
"latitude": "-27.660744",
"status": 1
},
{
"id": 41,
"name": "Forest Hill",
"slug": "forest-hill",
"location": null,
"longitude": "153.372922",
"latitude": "-27.661305",
"status": 1
},
{
"id": 42,
"name": "Doverton",
"slug": "doverton",
"location": null,
"longitude": "153.378732",
"latitude": "-27.662146",
"status": 1
}
]
}
}
]
}
