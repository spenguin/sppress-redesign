<?php
/**
 * Taxamo Class 
 */
class Taxamo {
    public $_url   = "https://seller-transaction-api.sandbox.marketplace.taxamo.com/api/v3/seller/transactions";    // Sandbox
    public $_postData;

    function __construct()
    {
        $this->_token   = TAXAMO_KEY;
    }

    function store()
    {
        $curl = curl_init();

        $this->set_postData();


        $postData   = [
            'transaction'    => [
                "currency_code"     => "GBP",
                "buyer_name"        => $this->_postData['name'],
                "invoice_timestamp" => $this->_postData['timestamp'], //"2020-05-20T01:59:59+04:00",
                "ship_to_address"   => $this->_postData['ship_to_address'],
                "description"       => $this->_postData['description'],
                "transaction_lines" => $this->_postData['transaction_lines']
                
                
 
            ]
        ];  //exit( json_encode(  $postData ) );


        curl_setopt_array( $curl, [
            CURLOPT_URL => $this->_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode( $postData ),
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Content-Type: application/json",
                "x-marketplace-seller-token: " . $this->_token
            ],
        ]);
        curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 0 );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0 );

        $response = curl_exec( $curl );
        $err = curl_error( $curl );

        curl_close( $curl );

        if ($err) 
        {
            exit( "cURL Error #:" . $err );
        } 
        else 
        {
            //echo "Success\n"; //"success":false,"
            $response   = json_decode( $response );
            if( property_exists( $response, 'success' ) && empty( $response->success ) )
            {
                exit( print_r( $response ) );
            }
            else
            {
                //exit( $response->transaction->key );
                $this->confirm( $response->transaction->key );
            }
        }
    }

    /**
     * Confirm stored transaction
     */
    function confirm( $key )
    {

        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => $this->_url . '/' . $key . "/confirm",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => [
            "Accept: application/json",
            "Content-Type: application/json",
            "x-marketplace-seller-token: " . $this->_token
        ],
        ]);

        curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 0 );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0 );        

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) 
        {
            exit( "cURL Error #:" . $err );
        } 
        else 
        {
            exit( print_r( $response ) );
        }
    }

    /**
     * Collect and sanitise $_POST data [FIX] - need to sanitise
     * @return array
     */
    function set_postData()
    {
        $this->_postData    = [
            'name'  => $_POST['_billing_first_name'] . ' ' . $_POST['_billing_last_name'],
            'timestamp' => $this->formTimestamp( $_POST['original_post_title'] ),
            'ship_to_address'   => [
                //'company_name'  => $_POST['_shipping_company'],
                'street_name'   => $_POST['_shipping_address_1'] . ' '  . $_POST['_shipping_address_2'] . ' ' . $_POST['_shipping_state'],
                'city'          => $_POST['_shipping_city'],
                'postal_code'   => $_POST['_shipping_postcode'],
                'country_code'  => $_POST['_shipping_country']
            ],
            'description'       => $_POST['post_title']
        ];
        $t  = [];
        foreach( $_POST['order_item_id'] as $i )
        {
            $t[]  = [
                'custom_id' => $i,
                'amount'    => $_POST['line_total'][$i],
                'ship_from_address' => ['country_code' => 'GB'],
                'product_class' => 'P',
                'description'   => 'Graphic Novel',
                'product_cn_code'   => '4901 99 00 00'
            ];
        }
        $this->_postData['transaction_lines']   = $t;
    }

    /**
     * Form Timestamp from Post Title string
     * @param str
     * @return str
     */
    function formTimestamp( $title )
    {   
        $title      = explode( '&ndash;', $title ); 
        $title      = explode( '@', $title[1] );
        $timeStamp  = date( DATE_ATOM, strtotime( trim( $title[1] ) ) );
        return $timeStamp;
    } 

    


}
/*

curl --request POST \
  --url https://seller-transaction-api.sandbox.marketplace.taxamo.com/api/v3/seller/transactions \
  --header 'content-type: application/json' \
  --header "x-marketplace-token: $TOKEN" \
  --data '{
    "transaction": {
        "currency_code": "EUR",
        "buyer_name": "Scenario #1 buyer",
        "invoice_timestamp": "2020-05-20T01:59:59+04:00",
        "ship_to_address": {
            "street_name": "30 Monmouth Street",
            "city": "Bath",
            "postal_code": "BA1 2AP",
            "country_code": "GB"
        },   
        "description": "Example sale to GB.",
        "transaction_lines": [
            {
        "seller_code": "EU1M",
                "custom_id": "line_1",
                "amount": 200,
                "ship_from_address": {"country_code": "CN"},
                "product_class": "P",
                
                "description": "Goods #1",              
                "parcel_reference": "3897329872423",
                "carrier_id": "DHL",
        "product_cn_code": "8504 31 80 15",
        "product_reference_number": ""
        
        
            }, 
    {
        "seller_code": "CN1M",
                "custom_id": "line_2",
                "amount": 100,
                "ship_from_address": {"country_code": "PL"},
                "product_class": "P",
                
                "description": "Goods #2",              
                "parcel_reference": "3897329872423",
                "carrier_id": "DHL",
        "product_cn_code": "8504 31 80 15",
        "product_reference_number": ""
        
        
    }]
    }
}'*/
