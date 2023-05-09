#include <SPI.h>
#include <MFRC522.h>
#define RST_PIN 9                  // Configurable, see typical pin layout above
#define SS_PIN 10                  // Configurable, see typical pin layout above
MFRC522 mfrc522(SS_PIN, RST_PIN);  // Create MFRC522 instance
char choice;

void setup() {
  Serial.begin(9600);  // Initialize serial communication at 9600 baud rate
  while(!Serial){}
  SPI.begin();
  mfrc522.PCD_Init();
  //mfrc522.PCD_DumpVersionToSerial();

}


void loop() {
  if (Serial.available()){
    choice = Serial.read();
    if (choice == '1'){
      readcard();
    }else if (choice == '2'){
      writecard();
    }
  }
}

void readcard(){
  if (mfrc522.PICC_IsNewCardPresent() && mfrc522.PICC_ReadCardSerial()) {
    byte block;
    byte len;
    String CEF = "";
    MFRC522::MIFARE_Key key;
    for (byte i = 0; i < 6; i++) key.keyByte[i] = 0xFF;
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
      if ((buffer[i] != 32)&&(buffer[i] != 10)){  // Check if the current byte is not a space character
        CEF += String(buffer[i]);
      }
    }
    String result;
    for (int i = 0; i < CEF.length(); i += 2) {
      char c = (char)((CEF.charAt(i) - '0') * 10 + (CEF.charAt(i + 1) - '0'));
      result += c;
    }
    String uid = "";
    for (byte i = 0; i < mfrc522.uid.size; i++) {
      uid += String(mfrc522.uid.uidByte[i] < 0x10 ? "0" : "");
      uid += String(mfrc522.uid.uidByte[i], HEX);
    }
    mfrc522.PICC_HaltA();
    mfrc522.PCD_StopCrypto1();
    Serial.println("SUCCESS: "+uid + "," + result);
    delay(1000);
  }else{
    Serial.println("ERROR: card not detected");
  }
}
void writecard(){
  if (mfrc522.PICC_IsNewCardPresent() && mfrc522.PICC_ReadCardSerial()) {
    MFRC522::MIFARE_Key key;
    for (byte i = 0; i < 6; i++) key.keyByte[i] = 0xFF;
    byte block = 4;
    byte len;
    byte data[16];
    Serial.println("insert CEF:");
    Serial.setTimeout(5000L);
    len = Serial.readBytesUntil('#', (char *) data, 16) ; // read family name from serial
    for (byte i = len; i < 16; i++) data[i] = ' ';     // pad with spaces
    MFRC522::StatusCode status = mfrc522.PCD_Authenticate(MFRC522::PICC_CMD_MF_AUTH_KEY_A, block, &key, &(mfrc522.uid));
    if (status != MFRC522::STATUS_OK) {
      Serial.print(F("Authentication failed: "));
      Serial.println(mfrc522.GetStatusCodeName(status));
      return;
    }
    status = mfrc522.MIFARE_Write(block, data, 16);
    if (status != MFRC522::STATUS_OK) {
      Serial.print(F("MIFARE_Write() failed: "));
      Serial.println(mfrc522.GetStatusCodeName(status));
      return;
    }
    Serial.println("SUCCESS: CEF written to card.");
    mfrc522.PICC_HaltA();
    mfrc522.PCD_StopCrypto1();
    delay(1000);
  }else{
    Serial.println("ERROR: card not detected");
  }
}