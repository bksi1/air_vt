#include <EEPROM.h>
#include <TinyGPS++.h> // library for GPS module
#include <SoftwareSerial.h>
#include <ESP8266WiFi.h>
#include <Adafruit_Si7021.h>
#include <ArduinoJson.h>
#include <ESP8266HTTPClient.h>

#define analog A0
#define ledPower D4

String dust_str = "0.00", date_str , time_str , lat_str , lng_str, temp_str, hum_str, token;
Adafruit_Si7021 sensor = Adafruit_Si7021();
int samplingTime = 280, deltaTime = 40, sleepTime = 9680, tokenAddress = 0, sensorAddress = 10;
float Temperature = 0, Humidity = 0, latitude , longitude;
TinyGPSPlus gps;  // The TinyGPS++ object
SoftwareSerial ss(12, 13); // The serial connection to the GPS device //d6 d7 -> gpio12 and gpio13
const char* ssid = "homeme";
const char* password = "pe6o3Pi4";
HTTPClient http;
bool hasToken = false;

void setup()
{

  pinMode(ledPower,OUTPUT);
  Serial.begin(115200);
  ss.begin(9600);
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);
  WiFi.begin(ssid, password); //connecting to wifi
  while (WiFi.status() != WL_CONNECTED)// while wifi not connected
  {
    delay(500);
    Serial.print("."); //print "...."
  }
  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println(WiFi.localIP());  // Print the IP address
  initTempSensor();

}

void checkToken() {
  byte firstValue;
  if (! hasToken) {
    EEPROM.begin(512);
    firstValue = EEPROM.read(tokenAddress);
    Serial.println("GPS LOCATION GET "+lat_str+" : "+lng_str);
    if (lat_str != "" && lng_str != "") {
      StaticJsonDocument<200> doc;
      if (firstValue == 255) { // clean EEPROM approached
        http.begin("http://vt-air.bksi-bg.com/api/gettoken?latitude="+lat_str + "&longitude=" + lng_str);
        int httpCode = http.GET();
        Serial.print("Request to server with response HttpCode ");
        Serial.println(httpCode);
        if (httpCode >0) {
            String payload = http.getString();
            Serial.print("Response: ");
            Serial.println(payload);
            DeserializationError error = deserializeJson(doc, payload);

            // DEBUG INFO
            /*Serial.print("Doc(success) ");
            Serial.println(doc["success"].as<int>());
            Serial.print("Doc(token) ");
            Serial.println(doc["token"].as<String>());*/

            if (!error && doc["success"] > 0) {
              token = doc["token"].as<String>();
              Serial.print("Write into EEPROM: ");
              EEPROM.put(tokenAddress, token);
              delay(200);
              EEPROM.commit();
            } else {
              Serial.println("json error");
              Serial.println(error.c_str());
            }
        } else {
          Serial.println(http.errorToString(httpCode).c_str());
        }
        http.end();
      } else {
        EEPROM.get(tokenAddress, token);
        Serial.print("Token red: ");
        Serial.println(token);
        hasToken = true;
      }
    } else {
      if (firstValue == 255) {
        Serial.println("Waiting 30sec till next GPS location check");
        delay(30000);
      } else {
        EEPROM.get(tokenAddress, token);
        hasToken = true;
      }
    }
    EEPROM.end();
  }
}

void initTempSensor() {
  Serial.println("Si7021 test!");

  if (!sensor.begin()) {
    Serial.println("Did not find Si7021 sensor!");
  }

  Serial.print("Found model ");
  switch(sensor.getModel()) {
    case SI_Engineering_Samples:
      Serial.print("SI engineering samples"); break;
    case SI_7013:
      Serial.print("Si7013"); break;
    case SI_7020:
      Serial.print("Si7020"); break;
    case SI_7021:
      Serial.print("Si7021"); break;
    case SI_UNKNOWN:
    default:
      Serial.print("Unknown");
  }
  Serial.print(" Rev(");
  Serial.print(sensor.getRevision());
  Serial.print(")");
  Serial.print(" Serial #"); Serial.print(sensor.sernum_a, HEX); Serial.println(sensor.sernum_b, HEX);
}

void checkGPSLocation() {
  while (ss.available() > 0) //while data is available
  {
    if (gps.encode(ss.read())) //read gps data
    {
      //Serial.println("Reading GPS data");
      if (gps.location.isValid()) //check whether gps location is valid
      {
        //Serial.println("GPS data valid");
        latitude = gps.location.lat();
        lat_str = String(latitude , 6); // latitude location is stored in a string
        longitude = gps.location.lng();
        lng_str = String(longitude , 6); //longitude location is stored in a string
        Serial.println(lat_str + " === " + lng_str);
      } else {
        Serial.write("Invalid gps location \n");
      }
    }
  }
}

void checkDust() {
    Serial.println("Lat str"+lat_str);
    int measured = 0;
    digitalWrite(ledPower,LOW); // power on the LED
    delayMicroseconds(samplingTime);
    measured = analogRead(analog);
    delayMicroseconds(deltaTime);
    digitalWrite(ledPower,HIGH); // turn the LED off
    delayMicroseconds(sleepTime);
    double calculated = 0;
    calculated = (0.17 * (measured * (3.3 / 1024)) - 0.01) * 1000;
    dust_str = String(calculated, 2);
    Serial.println(dust_str);
}

void checkTemperatureANdHumidity() {
  Temperature = sensor.readTemperature(); // Gets the values of the temperature
  Humidity = sensor.readHumidity(); // Gets the values of the humidity

  if (! isnan(Temperature)) {
    temp_str = String(Temperature, 2);
  } else {
    Serial.println("Nan temp");
  }
  if (! isnan(Humidity)) {
    hum_str = String(Humidity, 0);
  }
}


void loop()
{

   checkGPSLocation();
   checkToken();
   delay(3000);
   checkTemperatureANdHumidity();
   checkDust();

   Serial.println("Token used: "+token);

   if (lat_str != "" and lng_str != "") {
     http.begin("http://vt-air.bksi-bg.com/api/getdata?latitude="+lat_str + "&longitude=" + lng_str);
     int httpCode = http.POST(
      "{\"token\": \""+token+"\", \"sensor_types\"{\"1\":\""+temp_str+"\", \"2\":\""+dust_str+"\", \"3\":\""+hum_str+"\"}}"
      );
     Serial.print("Request to server with response HttpCode ");
     Serial.println(httpCode);
     if (httpCode >0) {
        String payload = http.getString();
     } else {
        Serial.println("Server error");
     }
   } else {
      Serial.println("GPS wrong location");
   }

}
