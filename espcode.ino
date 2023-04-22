
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
SDI  -----> D8
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
	mfrc522.PCD_DumpVersionToSerial();
  //connection m3a lwifi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");
  //declaration dial led likayna f esp8266
  pinMode(LED_BUILTIN, OUTPUT);
}

void loop() {
  digitalWrite(LED_BUILTIN, HIGH);
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
    senddata(Card_uid);
  }
}
//lfunction li katssift l UID dial lcard l server
void senddata(String Card_uid) {
  Serial.println(Card_uid);

  if (WiFi.status() == WL_CONNECTED){
    HTTPClient http;
    WiFiClient client;
    http.begin(client, url);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    int httpCode = http.POST("cardUID=" + String(Card_uid));
    //script kaychof wach data tssiftat nit ola kayn chi mochkil f server, ila makan 7ta mochkil katch3l lbola dial esp8266 
    if (httpCode == -1) {
      Serial.println("Server not responding");
    } else {
      digitalWrite(LED_BUILTIN, LOW);
      String response = http.getString();
      http.end();
      // script kayjib kolchi lidar lih echo f fichier getUID.php kansstkhdmo bach n confirmer lcondition dial request
      Serial.println("HTTP response code: " + String(httpCode));
      Serial.println("Response: " + response);
      delay(200);// Wait for a second
      digitalWrite(LED_BUILTIN, HIGH);  // Turn the LED off by making the voltage HIGH
    }
  }else{
    Serial.println("WiFi not connected");
  }
}