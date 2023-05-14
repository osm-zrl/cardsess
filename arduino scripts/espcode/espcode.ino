
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <SPI.h>
#include <MFRC522.h>

/* -------------------------------------------------------
RST  -----> D1
3.3V -----> 3v
GND  -----> GND
MISO -----> D6
MOSI -----> D7
SCK  -----> D5
SDA  -----> D8
green LED > D2
orange LED > D3
red LED > D0
------------------------------------------------------- */

#define SS_PIN D8   // Set the SS pin for the RC522
#define RST_PIN D1  // Set the RST pin for the RC522

MFRC522 mfrc522(SS_PIN, RST_PIN);  // Create an instance of the MFRC522 library

//declaring dial les constantes
const char* ssid = "DESKTOP-6JT69FG";       // Replace with your network name (SSID)
const char* password = "hellohello1234";    // Replace with your network password
const char* url = "http://192.168.137.1/atdc/getUID.php";

String OldCarduid = "";
unsigned long previousMillis = 0;

void setup() {
  Serial.begin(115200);
  delay(10);
  //initialization dial sensor rfid
  SPI.begin();         // Initialize SPI
  mfrc522.PCD_Init();  // Initialize the RC522
  Serial.println("RFID reader initialized");

  pinMode(D2, OUTPUT); //green led
  pinMode(D3, OUTPUT); //orange led
  pinMode(D0, OUTPUT); //red led

	mfrc522.PCD_DumpVersionToSerial();
  //connection m3a lwifi
  WiFi.begin(ssid, password);
  
  connecttowifi();
  //declaration dial led likayna f esp8266
  pinMode(LED_BUILTIN, OUTPUT);
  digitalWrite(D2,LOW);
  digitalWrite(D3,LOW);
  digitalWrite(D0,LOW);
  digitalWrite(LED_BUILTIN, HIGH);
  
}

void loop() {
  if(WiFi.status() != WL_CONNECTED){
    connecttowifi();
  }
  
  //script kay7bss la carte l9dima tsskana 15s
  if (millis() - previousMillis >= 15000) {
    previousMillis = millis();
    OldCarduid="";
  }
  delay(50);
  //condition katkon true fach kat scana chi carte
  if (mfrc522.PICC_IsNewCardPresent() && mfrc522.PICC_ReadCardSerial()) {
    digitalWrite(LED_BUILTIN, LOW);
    delay(200);// Wait for a second
    String CEF = "";
    MFRC522::MIFARE_Key key;
    for (byte i = 0; i < 6; i++) key.keyByte[i] = 0xFF;
    byte block;
    byte len;
    MFRC522::StatusCode status;



    byte buffer[18];
    block = 4;
    len = 18;

    status = mfrc522.PCD_Authenticate(MFRC522::PICC_CMD_MF_AUTH_KEY_A, block, &key, &(mfrc522.uid));
    if (status != MFRC522::STATUS_OK) {
      Serial.print(F("Authentication failed: "));
      Serial.println(mfrc522.GetStatusCodeName(status));
      return;
    }

    status = mfrc522.MIFARE_Read(block, buffer, &len);
    if (status != MFRC522::STATUS_OK) {
      Serial.print(F("Reading failed: "));
      Serial.println(mfrc522.GetStatusCodeName(status));
      return;
    }

    for (uint8_t i = 0; i < 16; i++) {
      if (buffer[i] != 32) { // Check if the current byte is not a space character
        CEF += String(buffer[i]);
      }
    }
    String result;
    for (int i = 0; i < CEF.length(); i += 2) {
      char c = (char) ((CEF.charAt(i) - '0') * 10 + (CEF.charAt(i + 1) - '0'));
      result += c;
    }
    digitalWrite(LED_BUILTIN, HIGH);  // Turn the LED off by making the voltage HIGH
    String Card_uid = "";
    for (byte i = 0; i < mfrc522.uid.size; i++) {
      Card_uid += String(mfrc522.uid.uidByte[i] < 0x10 ? "0" : "");
      Card_uid += String(mfrc522.uid.uidByte[i], HEX);
    }
    mfrc522.PICC_HaltA();       // Halt PICC
    mfrc522.PCD_StopCrypto1();  // Stop encryption on PCD
    //condition katchof wach nfss lcarte l9dima ola la, ila kant nfssha makatssifthach l server
    if( Card_uid == OldCarduid ){
      return;
    }
    else{
      OldCarduid = Card_uid;
    }
    senddata(Card_uid,result);
  }
}
//lfunction li katssift l UID dial lcard l server
void senddata(String Card_uid,String CEF) {
  Serial.println(Card_uid);
  if (WiFi.status() == WL_CONNECTED){
    HTTPClient http;
    WiFiClient client;
    http.begin(client, url);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    int httpCode = http.POST("cardUID=" + String(Card_uid)+"&CEF=" + String(CEF));
    //script kaychof wach data tssiftat nit ola kayn chi mochkil f server, ila makan 7ta mochkil katch3l lbola dial esp8266 
    if (httpCode == -1) {
      Serial.println("Server not responding");
      digitalWrite(D3,HIGH);  
      delay(1000);   
    } else {
      String response = http.getString();
      http.end();
      // script kayjib kolchi lidar lih echo f fichier getUID.php kansstkhdmo bach n confirmer lcondition dial request
      Serial.println("HTTP response code: " + String(httpCode));
      if(response == "0"){
        digitalWrite(D2,HIGH);
        delay(1000);
        digitalWrite(D2,LOW);
      }else if(response == "1"){
        digitalWrite(D3,HIGH);
        delay(1000);
        digitalWrite(D3,LOW);
      }else{
        digitalWrite(D0,HIGH);
        delay(1000);
        digitalWrite(D0,LOW);
      }      
    }
  }else{
    Serial.println("WiFi not connected");
    connecttowifi();
  }
}
void connecttowifi(){
  while (WiFi.status() != WL_CONNECTED) {
    digitalWrite(D3,HIGH);
    delay(1000);
    Serial.println("Connecting to WiFi...");
    digitalWrite(D3,LOW);
    delay(1000);
  }
  Serial.println("Connected to WiFi");
}