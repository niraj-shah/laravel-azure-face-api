## Setup

### Install Library

Using composer, manually add the library to the `composer.json` file:

```json
"repositories": [
    {
        "url": "git@github.com:niraj-shah/laravel-azure-face-api.git",
        "type": "git"
    }
],
```

Run `composer update` to update or install the library.

### Update Providers

Update the `config/app.php` file to add the following line to the `providers` array:

```php
AzureFace\AzureFaceServiceProvider::class,
```

And the following line to the `aliases` array:

```php
'AzureFace' => AzureFace\Facades\AzureFace::class,
```

### Test the library

For a quick check, you can use the following code in a controller:

```php
$face = AzureFace::detectFacesFromUrl('https://upload.wikimedia.org/wikipedia/commons/thumb/d/d2/Donald_Trump_August_19%2C_2015_%28cropped%29.jpg/245px-Donald_Trump_August_19%2C_2015_%28cropped%29.jpg', [
    'recognitionModel' => 'recognition_02',
    'detectionModel' => 'detection_01',
    'returnFaceId' => 'true',
    'returnFaceLandmarks' => 'true',
    'returnFaceAttributes' => 'age,gender,glasses,smile,noise,hair,accessories,emotion,makeup,headPose,facialHair,occlusion,blur,exposure',
]);

dd($face);
```

## Examples

Detect Faces using URL.

```php
$face = AzureFace::detectFacesFromUrl('https://upload.wikimedia.org/wikipedia/commons/thumb/d/d2/Donald_Trump_August_19%2C_2015_%28cropped%29.jpg/245px-Donald_Trump_August_19%2C_2015_%28cropped%29.jpg', [
    'recognitionModel' => 'recognition_02',
    'detectionModel' => 'detection_01',
    'returnFaceId' => 'true',
    'returnFaceLandmarks' => 'true',
    'returnFaceAttributes' => 'age,gender,glasses,smile,noise,hair,accessories,emotion,makeup,headPose,facialHair,occlusion,blur,exposure',
]);
```

Detect Faces using file file (uploaded as binary)

```php
$face = AzureFace::detectFacesFromFile(file_get_contents(public_path('IMG.jpg')), [
    'recognitionModel' => 'recognition_02',
    'detectionModel' => 'detection_01',
    'returnFaceId' => 'true',
    'returnFaceLandmarks' => 'true',
    'returnFaceAttributes' => 'age,gender,glasses,smile,noise,hair,accessories,emotion,makeup,headPose,facialHair,occlusion,blur,exposure',
]);
```
