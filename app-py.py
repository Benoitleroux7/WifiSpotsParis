
import urllib.request, json 
with urllib.request.urlopen("http://localhost/view/rest/getDataDistrict16.php") as url:
    data = json.loads(url.read().decode())
    #print(data)
    
#print(json.dumps(data, indent=4))

#cp=input("Entrez le code postal")

from flask import Flask, render_template         # import flask
app = Flask(__name__)             # create an app instance

@app.route("/")                   # at the end point /


def home():
   return render_template('home.html',len=len(data["Spots WiFi"]),cp=data["Spots WiFi"])
   
              

if __name__ == "__main__":        # on running python app.py
    app.run()                     # run the flask app




