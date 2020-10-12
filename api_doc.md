-/login, post
    format: x-www-fom-urlencoded
    request: { "email":"a@gmail.com", "password":"123456"}
    response: {"status": "success",
                "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYzdhOTcyMzk1ZWIxNWRiNzViZjdlYWIwYjExZmNkZTY4NGJhZDU2ZjhmZGU2ZjhjN2EzZjFiMDk4MTBiZGNkNGI5ZGZhZTE4MWY0ZWMxMzciLCJpYXQiOjE1OTc3NjU5MzUsIm5iZiI6MTU5Nzc2NTkzNSwiZXhwIjoxNjI5MzAxOTM1LCJzdWIiOiIzIiwic2NvcGVzI",
                "message": "Login success" }

-/register, post
    format: x-www-fom-urlencoded
    request: { "firstname":"li", "lastname":"lee", "email":"a@gmail.com", "password":"123456", "c_password":"123456"}
    response: {"status": "success",
                "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYzdhOTcyMzk1ZWIxNWRiNzViZjdlYWIwYjExZmNkZTY4NGJhZDU2ZjhmZGU2ZjhjN2EzZjFiMDk4MTBiZGNkNGI5ZGZhZTE4MWY0ZWMxMzciLCJpYXQiOjE1OTc3NjU5MzUsIm5iZiI6MTU5Nzc2NTkzNSwiZXhwIjoxNjI5MzAxOTM1LCJzdWIiOiIzIiwi",
                "message": "User registered successfully." }

-/person, post
-/person/{id}, put
    header: Authorization
    request: {"firstname":"firstName","lastname":"lastName","company":"company"}
    response: {
                "firstname": "firstName",
                "lastname": "lastName",
                "company": "company",
                "created_by": "userid",
                "updated_by": "userid",
                "id": "d2876bef-a6fb-4a11-86bc-901fd877d034",
                "updated_at": "2020-08-12 15:39:30",
                "created_at": "2020-08-12 15:39:30"
            }

-/lead, post
    header: Authorization
    request: {"personid":"33fb64cd-bea6-43c5-9d95-b56cff7987db"}
    response: {
        "id": "9ab47d8c-4f2e-43c4-bea1-e3cb0ff8ff00",
        "personid": "33fb64cd-bea6-43c5-9d95-b56cff7987db",
        "created_by": "user",
        "updated_by": "user",
        "updated_at": "2020-08-18 02:47:35",
        "created_at": "2020-08-18 02:47:35"
    }

-/lead/{id}, delete
    header: Authorization
    response: {
        "status": "success"
    }

-/lead/{id}, get
    header: Authorization
    response: {
        "lead": {
            "id": "9ab47d8c-4f2e-43c4-bea1-e3cb0ff8ff00",
            "personid": "33fb64cd-bea6-43c5-9d95-b56cff7987db",
        },
        "leaddetail": {
            "id": "9ab47d8c-4f2e-43c4-bea1-e3cb0ff8ff00",
            "personid": "33fb64cd-bea6-43c5-9d95-b56cff7987db",
            "email": "a@a.com",
            "besttimetocall": "best time to call",
            "hearaboutus": "hear about us",
            "howtocanwehelp": "how to can we help",
        },
        "person": {
            "id": "33fb64cd-bea6-43c5-9d95-b56cff7987db",
            "firstname": "per",
            "lastname": "per",
            "status": 1,
        },
        "address": [
                {
                "id": "ecbf51c8-6fcd-4c8d-b894-342cc0776757",
                "personid": "33fb64cd-bea6-43c5-9d95-b56cff7987db",
                "address1": "May St",
                "address2": null,
                "city": "Perth",
                "state": "AK",
                "zip": "13235",
                "primary": 1,
                }
            ]
        }
        "phone": [
                {
                "id": "ecbf51c8-6fcd-4c8d-b894-342cc0776757",
                "personid": "33fb64cd-bea6-43c5-9d95-b56cff7987db",
                "number": "0000",
                "primary": 1,
                }
            ]
        }
    }

-/leads, get
    header: Authorization
    response: {
        [
        {
            "id": "idtest1",
            "personid": "personidtest1",
            "person": [
                {
                    "id": "personidtest1",
                    "firstname": "person1",
                    "lastname": "pserson1",
                    "company": "company",
                }
            ]
        },
        {
            "id": "test3",
            "personid": "personidtest3",
            "person": [
                {
                    "id": "personidtest3",
                    "firstname": "person3",
                    "lastname": "person3",
                    "company": "company",
                }
            ]
        }
        ],
    }

-/phonetype, get
    response: {
        [
        {
            "phonetype": "cell"
        },
        {
            "phonetype": "home"
        },
        {
            "phonetype": "office"
        }
        ]
    }

-/phone, post
-/phone/{id}, put
    request: {"personid":"acef5eb6-381f", "number":"1234", "type":"home", "primary":1}
    response: { "id": "d632514e-01bf", "personid": "acef5eb6-381f", "number": "1234", "type": "home", "primary":1}

-/addresstype, get
    response: {
        [
        {
            "addresstype": "billing"
        },
        {
            "addresstype": "home"
        },
        {
            "addresstype": "main"
        },
        {
            "addresstype": "office"
        }
        ]
    }

-/address, post
-/address/{id}, put
    request: {"personid":"33fb64cd-bea6","address1":"May St", "address2":"St", "city":"Perth", "state":"AK", "zip":"13235", "primary":1}
    response: { "id": "ecbf51c8-6fcd-4c8d-b894-342cc0776757",
                "personid": "33fb64cd-bea6",
                "address1": "May St",
                "address2":"St",
                "city": "Perth",
                "state": "AK",
                "zip": "13235",
                "primary": 1,
                "created_by": 3,
            }



-/leaddetail, post
-/leaddetail/{id}, put
    header: Authorization
    request: {"leadid":"acef5eb6-381f-4f5c-855b-12bde5201b23",
                "email":"email@mail.com",
                "besttimetocall":"Morning",
                "hearaboutus":"How did you hear about us?",
                "howcanwehelp":"How can we help?"
            }
    response: {
                "id": "8bc8abe1-52b1-406a-9cd9-d6861a0f2df3",
                "leadid": "acef5eb6-381f-4f5c-855b-12bde5201b23",
                "email": "email@mail.com",
                "besttimetocall": "Morning",
                "hearaboutus": "How did you hear about us?",
                "howcanwehelp": "How can we help?",
            }

-/color, post
-/color/{id}, put
    header: Authorization
    request: {"name":"red"}
    response: {
            "status": "success",
            "id": "f968141f-2b68-4648-b5ac-8c50e636a311",
            "name": "redblack"
        }

-/colors, get
    response: {
        [
        {
            "id": "4f19cd65-2c3d-48b7-9444-aabfe694a5d3",
            "name": "red",
        },
        {
            "id": "c0487478-9951-4893-9072-a96d55ea70dc",
            "name": "white",
        },
        ]
    }

-/color/{id}, delete
    header: Authorization
    response: {
        "status": "success"
    }

-/pattern, post
-/pattern/{id}, put
    header: Authorization
    request: {"name":"pattern"}
    response: {
                "status": "success",
                "id": "8bc8abe1-52b1-406a-9cd9-d6861a0f2df3",
                "name": "pattern"
            }

-/patterns, get
    response: {
        [
        {
            "id": "4f19cd65-2c3d-48b7-9444-aabfe694a5d3",
            "name": "pattern",
        },
        {
            "id": "c0487478-9951-4893-9072-a96d55ea70dc",
            "name": "pattern",
        },
        ]
    }

-/pattern/{id}, delete
    header: Authorization
    response: {
        "status": "success"
    }

-/ingredient, post
-/ingredient/{id}, put
    header: Authorization
    request: {  "name":"Name",
                "coverage":4,
                "purchageprice":50,
                "color":["colorId1","colorId2"],
                "pattern":["patternId1","patternId2"]
            }
    response: {
                "id": "642cfdb4-6fd1-4e79-b137-1158d679306a",
                "name": "Name",
                "coverage": 4,
                "purchageprice": 60,
                "color":["colorId1","colorId2"],
                "pattern":["patternId1","patternId2"]
            }

-/ingredients, get
    response: {
        [
        {
            "id": "642cfdb4-6fd1-4e79-b137-1158d679306a",
            "name": "Name",
            "coverage": 4,
            "purchageprice": 60
        },
        {
            "id": "642cfdb4-6fd1-4e79-b137-1158d679306a",
            "name": "Name",
            "coverage": 4,
            "purchageprice": 60
        },
        ]
    }

-/ingredient/{id}, delete
    header: Authorization
    response: {
        "status": "success"
    }

-/ingredient/{id}, get
    response: { "name":"Name",
                "coverage":4,
                "purchageprice":50,
                "color":["colorId1","colorId2"],
                "pattern":["patternId1","patternId2"]}
            }

-/system, post
-/system/{id}, put
    header: Authorization
    request: {  "name":"test system",
                "saleprice":23,
                "ingredients":[
                    {"ingredientid":"id", "extra": "extra", "factor": "7", "price":30}
                ]
            }
    response: {
                "id": "642cfdb4-6fd1-4e79-b137-1158d679306a",
                "name":"test system",
                "saleprice":23
                "ingredients":[
                    {"ingredientid":"id", extra: "extra", "factor": "7", "price":30}
                ]
            }

-/system/{id}, get
    header: Authorization
    response: {
                "id": "642cfdb4-6fd1-4e79-b137-1158d679306a",
                "name":"test system",
                "saleprice":23
                "ingredients":[
                    {"ingredientid":"id", extra: "extra", "factor": "7", "price":30}
                ]
            }

-/system/{id}, delete
    header: Authorization
    response: {
        "status": "success"
    }

-/systems, get
    response: {
        [
        {
            "id": "642cfdb4-6fd1-4e79-b137-1158d679306a",
            "name": "Name"
        },
        {
             "id": "642cfdb4-6fd1-4e79-b137-1158d679306a",
            "name": "Name",
        },
        ]
    }

-/contracttemplate, post
-/contracttemplate/{id}, put
    request:{
        "name":"name",
        "logo": "logo",
        "notetocustomer": "notetocustomer",
        "scopeofwork": "scopeofwork",
        "commoncondition": "commoncondition",
        "downpaymentterms": "downpaymentterms",
        "note": "note",
        "conclusion": "conclusion",
        "footer": "footer"
    }
    response:{
        "id": "asdf-2342",
        "name":"name",
        "logo": "logo",
        "notetocustomer": "notetocustomer",
        "scopeofwork": "scopeofwork",
        "commoncondition": "commoncondition",
        "downpaymentterms": "downpaymentterms",
        "note": "note",
        "conclusion": "conclusion",
        "footer": "footer"
    }

-/contracttemplate/{id}, get
    response:{
            "id": "asdf-2342",
            "name":"name",
            "logo": "logo",
            "notetocustomer": "notetocustomer",
            "scopeofwork": "scopeofwork",
            "commoncondition": "commoncondition",
            "downpaymentterms": "downpaymentterms",
            "note": "note",
            "conclusion": "conclusion",
            "footer": "footer"
        }

-/contracttemplates, get
    response: {
        [
        {
            "id": "642cfdb4-6fd1-4e79-b137-1158d679306a",
            "name":"name",
            "logo": "logo",
            "notetocustomer": "notetocustomer",
            "scopeofwork": "scopeofwork",
            "commoncondition": "commoncondition",
            "downpaymentterms": "downpaymentterms",
            "note": "note",
            "conclusion": "conclusion",
            "footer": "footer"
        },
        {
             "id": "642cfdb4-6fd1-4e79-b137-1158d679306a",
            "name":"name",
            "logo": "logo",
            "notetocustomer": "notetocustomer",
            "scopeofwork": "scopeofwork",
            "commoncondition": "commoncondition",
            "downpaymentterms": "downpaymentterms",
            "note": "note",
            "conclusion": "conclusion",
            "footer": "footer"
        },
        ]
    }

-/contracttemplate/{id}, delete
    header: Authorization
    response: {
        "status": "success"
    }

/project, post
request:{"leadid"}
response:{"projectid"}

/projects, get

[
    {
        "id": "7a8c0920-bbbb-4f3a-8b3d-97771335cdfe",
        "leadid": "lead4",
        "projectstatus": "estimate",
        "created_by": "3",
        "updated_by": "3",
        "created_at": "2020-08-28 17:13:09",
        "updated_at": "2020-08-28 17:13:09",
        "install": null,
        "designconsult": null,
        "addressid": "address5",
        "person": {
            "id": "person4",
            "firstname": "Raul",
            "lastname": "Jhon",
            "status": 1,
            "version": 0,
            "created_by": "3",
            "updated_by": "3",
            "company": "Concrete",
            "created_at": null,
            "updated_at": null
        },
        "address": {
            "id": "address5",
            "personid": "person4",
            "address1": "Snaframcisco",
            "address2": null,
            "city": "San",
            "state": "US",
            "zip": "2201",
            "type": "",
            "status": 1,
            "version": 0,
            "created_by": "3",
            "updated_by": "3",
            "primary": 1,
            "created_at": null,
            "updated_at": null
        }
    },
    {
        "id": "a7e13e6b-919e-4a59-bd4e-92501c120d84",
        "leadid": "lead4",
        "projectstatus": "estimate",
        "created_by": "3",
        "updated_by": "3",
        "created_at": "2020-08-28 17:13:41",
        "updated_at": "2020-08-28 17:13:41",
        "install": null,
        "designconsult": null,
        "addressid": "address5",
        "person": {
            "id": "person4",
            "firstname": "Raul",
            "lastname": "Jhon",
            "status": 1,
            "version": 0,
            "created_by": "3",
            "updated_by": "3",
            "company": "Concrete",
            "created_at": null,
            "updated_at": null
        },
        "address": {
            "id": "address5",
            "personid": "person4",
            "address1": "Snaframcisco",
            "address2": null,
            "city": "San",
            "state": "US",
            "zip": "2201",
            "type": "",
            "status": 1,
            "version": 0,
            "created_by": "3",
            "updated_by": "3",
            "primary": 1,
            "created_at": null,
            "updated_at": null
        }
    },
    {
        "id": "3b556df8-9860-450e-b2eb-b1a91d4b1b98",
        "leadid": "lead4",
        "projectstatus": "estimate",
        "created_by": "3",
        "updated_by": "3",
        "created_at": "2020-08-28 17:23:15",
        "updated_at": "2020-08-28 17:23:15",
        "install": null,
        "designconsult": null,
        "addressid": "address5",
        "person": {
            "id": "person4",
            "firstname": "Raul",
            "lastname": "Jhon",
            "status": 1,
            "version": 0,
            "created_by": "3",
            "updated_by": "3",
            "company": "Concrete",
            "created_at": null,
            "updated_at": null
        },
        "address": {
            "id": "address5",
            "personid": "person4",
            "address1": "Snaframcisco",
            "address2": null,
            "city": "San",
            "state": "US",
            "zip": "2201",
            "type": "",
            "status": 1,
            "version": 0,
            "created_by": "3",
            "updated_by": "3",
            "primary": 1,
            "created_at": null,
            "updated_at": null
        }
    }
]

/projectdetail, post
{
 "projectid" :"ece03857-3d74-4577-94db-58ddc1bca724",
 "projectdetails":[
	{
	"systemid":"7faa75bc-2593-49cd-8708-9a8cdc77e533",
	"areaprice":2,
	"area":12,
	"areawidth":3,
	"arealength":4,
	"name": "area test",
	"systemprice":40,
	"salesprice":20,
	"projectdetailstyles":[
		{
		"ingredientid":"ingredientid",
		"colorid":"colorid",
		"patternid":"patternid",
		"purchaseprice":"30",
		"chargeprice":"20"
    		}
		]
	}
 	]
}

-localhost:8000/api/team, post
    request:{"name":"test team"}
    response:{
            "name": "test team",
            "owner": "648b5f34-eb0f-4454-a4ab-eef34b92b304",
            "id": "9ba782c7-e0de-409c-aa8d-679a395abd35",
            "updated_at": "2020-10-12 01:06:30",
            "created_at": "2020-10-12 01:06:30"
        }

-localhost:8000/api/team/project/9ba782c7-e0de-409c-aa8d-679a395abd35, get
    response:[
                {
                    "id": "b33e2890-d8c5-40c6-9a74-f79a28982b72",
                    "leadid": "2ac824b7-e724-43c0-9b7c-79e742a4ffb5",
                    "install": "2020-09-20",
                    "share": 1,
                    "active": 1,
                    "addressid": null,
                    "projectstatus": "complete",
                    "created_by": "648b5f34-eb0f-4454-a4ab-eef34b92b304",
                    "updated_by": "648b5f34-eb0f-4454-a4ab-eef34b92b304",
                    "designconsult": null,
                    "created_at": "2020-09-14 13:57:24",
                    "updated_at": "2020-09-30 00:28:48",
                    "completed": "2020-09-08",
                    "person": {
                        "id": "17216506-0255-4f66-982b-fedb38c54199",
                        "firstname": "diego",
                        "lastname": "costa",
                        "created_by": null,
                        "updated_by": null,
                        "company": "Diego Costa com",
                        "created_at": "2020-09-02 02:34:26",
                        "updated_at": "2020-09-20 17:14:13"
                    },
                    "address": null
                }
            ]


-localhost:8000/api/teammember, post
    request:{"email":"test2@gmail.com"}
    response:{
            "status": "success",
            "member": {
                "teamid": "9ba782c7-e0de-409c-aa8d-679a395abd35",
                "userid": "7e16b2cc-ada8-43c7-8c79-123689246e1f",
                "id": "645f0d2d-fde8-4bdf-a5b6-201311468a92",
                "updated_at": "2020-10-12 01:51:07",
                "created_at": "2020-10-12 01:51:07"
            }
        }
-localhost:8000/api/teammembers, get
    response:{
            "member": [
                {
                    "id": "645f0d2d-fde8-4bdf-a5b6-201311468a92",
                    "teamid": "9ba782c7-e0de-409c-aa8d-679a395abd35",
                    "userid": "7e16b2cc-ada8-43c7-8c79-123689246e1f",
                    "created_at": "2020-10-12 01:51:07",
                    "updated_at": "2020-10-12 01:51:07"
                }
            ],
            "status": "success"
        }

-localhost:8000/api/teammember/645f0d2d-fde8-4bdf-a5b6-201311468a92, delete
    response:{
            "status":"success"
        }










