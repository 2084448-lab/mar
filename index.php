<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">

 <meta name="viewport"
 content="width=device-width, initial-scale=1.0">

 <title>CU AR Department Directory</title>

 <!-- Three.js and MindAR ES Module Imports -->
 <script type="importmap">
 {
 "imports": {
 "three": "https://unpkg.com/three@0.160.0/build/three.module.js",
 "three/addons/": "https://unpkg.com/three@0.160.0/examples/jsm/",
 "mindar-image-three": "https://cdn.jsdelivr.net/npm/mind-ar@1.2.5/dist/mindar-image-three.prod.js"
 }
 }
 </script>

 <style>

 * {
 box-sizing: border-box;
 }

 body {
 margin: 0;
 font-family: Arial, sans-serif;
 background: #101828;
 color: white;
 text-align: center;
 }

 header {
 padding: 20px;
 background: #123b68;
 }

 h1 {
 font-size: 22px;
 margin-bottom: 5px;
 }

 #startButton {
 padding: 14px 25px;
 margin: 20px;
 background: #f2b632;
 color: #123b68;
 border: none;
 border-radius: 8px;
 font-weight: bold;
 cursor: pointer;
 }

 #startButton:disabled {
 opacity: 0.5;
 }

 #ar-container {
 width: 100%;
 height: 75vh;
 overflow: hidden;
 position: relative;
 }

 #ar-container canvas {
 pointer-events: auto !important;
 touch-action: none;
 z-index: 2;
 }

 #ar-container video {
 pointer-events: none !important;
 }

 #ar-container {
 touch-action: none;
 }

 #departmentScreen {
 position: fixed;
 inset: 0;
 z-index: 1000;
 background: #101828;
 color: white;
 overflow-y: auto;
 padding: 20px;
 }

 #backButton {
 display: block;
 padding: 12px 20px;
 margin-bottom: 20px;
 background: #f2b632;
 color: #123b68;
 border: none;
 border-radius: 8px;
 font-weight: bold;
 cursor: pointer;
 }

 .department-content {
 max-width: 650px;
 margin: auto;
 padding: 20px;
 background: #1c2b41;
 border-radius: 15px;
 }

 #departmentLogo {
 width: 130px;
 height: 130px;
 object-fit: contain;
 display: block;
 margin: 10px auto;
 background: white;
 border-radius: 12px;
 }

 #departmentName {
 text-align: center;
 color: #f2b632;
 }

 #departmentDescription {
 line-height: 1.7;
 text-align: justify;
 color: #d1d5db;
 }

 .department-content h3 {
 color: #f2b632;
 margin-top: 25px;
 }

 #mascot-container {
 width: 100%;
 height: 350px;
 background: #26374d;
 border-radius: 12px;
 overflow: hidden;
 }

 #mascot-container canvas {
 width: 100%;
 height: 100%;
 display: block;
 }

 #mascotName {
 text-align: center;
 font-weight: bold;
 color: #f2b632;
 }


 </style>

</head>

<body>

 <header>

 <h1>Capitol University</h1>

 <p>AR Department Directory</p>

 </header>

 <button id="startButton">
 Start AR Scanner
 </button>

 <div id="ar-container"></div>


<!-- DEPARTMENT INFORMATION SCREEN -->

<div id="departmentScreen" style="display: none;">

 <button id="backButton">
 ← Back to Departments
 </button>

 <div class="department-content">

 <img id="departmentLogo" src="" alt="Department Logo">

 <h2 id="departmentName"></h2>

 <h3>About the Department</h3>

 <p id="departmentDescription"></p>

 <h3>Official Animal Mascot</h3>

 <div id="mascot-container"></div>

 <p id="mascotName"></p>

 </div>

</div>



 <!-- MAIN AR JAVASCRIPT -->
 
<script type="module">

 import * as THREE from 'three';

 import {
 MindARThree
 } from 'mindar-image-three';

 import {
 GLTFLoader
 } from 'three/addons/loaders/GLTFLoader.js';


 // =====================================
 // 1. DEPARTMENT INFORMATION
 // =====================================

 const departments = [

 {
 id: 1,
 name: "College of Computer Studies",
 file: "CCS.JPG"
 },

 {
 id: 2,
 name: "College of Business and Accountancy",
 file: "CBA.JPG"
 },

 {
 id: 3,
 name: "College of Criminology",
 file: "COC.JPG"
 },

 {
 id: 4,
 name: "College of Education",
 file: "COEE.JPG"
 },

 {
 id: 5,
 name: "College of Maritime Education",
 file: "CME.JPG"
 },

 {
 id: 6,
 name: "College of Health Sciences",
 file: "COHS.JPG"
 },

 {
 id: 7,
 name: "College of Engineering",
 file: "COE.JPG"
 },

 {
 id: 8,
 name: "College of Arts and Sciences",
 file: "ARTS.JPG"
 }

 ];


 // =====================================
 // DEPARTMENT DETAILS AND MASCOTS
 // =====================================

 const departmentDetails = {

 1: {
 logo: "CCS.JPG",
 description: "Description for the College of Computer Studies.",
 mascot: "Falcon",
 model: "falcon.glb"
 },

 2: {
 logo: "CBA.JPG",
 description: "Description for the College of Business and Accountancy.",
 mascot: "Eagle",
 model: "eagle.glb"
 },

 3: {
 logo: "COC.JPG",
 description: "Description for the College of Criminology.",
 mascot: "Purple",
 model: "purple.glb"
 },

 4: {
 logo: "COEE.GPG",
 description: "Description for the College of Education.",
 mascot: "Phoenix",
 model: "pheonix.glb"
 },

 5: {
 logo: "CME.JPG",
 description: "Description for the College of Maritime Education.",
 mascot: "Shark",
 model: "shark.glb"
 },

 6: {
 logo: "COHS.JPG",
 description: "Description for the College of Health Sciences.",
 mascot: "Snake",
 model: "snake.glb"
 },

 7: {
 logo: "COE.JPG",
 description: "Description for the College of Engineering.",
 mascot: "Beaver",
 model: "beaver.glb"
 },

 8: {
 logo: "ARTS.JPG",
 description: "Description for the College of Arts and Sciences.",
 mascot: "Red Knight",
 model: "redknight.glb"
 }

 };


 // =====================================
 // 3D MASCOT VIEWER
 // =====================================

 let mascotRenderer = null;
 let mascotScene = null;
 let mascotCamera = null;
 let currentMascot = null;
 let mascotFrame = null;

 const gltfLoader = new GLTFLoader();


 function loadMascot(modelFile) {

 const container =
 document.getElementById("mascot-container");

 // Clear previous 3D viewer
 if (mascotFrame) {
 cancelAnimationFrame(mascotFrame);
 mascotFrame = null;
 }

 if (mascotRenderer) {
 mascotRenderer.dispose();
 mascotRenderer.domElement.remove();
 mascotRenderer = null;
 }

 if (currentMascot && mascotScene) {
 mascotScene.remove(currentMascot);
 currentMascot = null;
 }

 // Create separate 3D scene
 mascotScene = new THREE.Scene();

 mascotScene.background =
 new THREE.Color(0x26374d);


 // Create camera
 mascotCamera = new THREE.PerspectiveCamera(
 45,
 container.clientWidth / container.clientHeight,
 0.1,
 1000
 );

 mascotCamera.position.set(0, 1, 4);


 // Create renderer
 mascotRenderer = new THREE.WebGLRenderer({
 antialias: true,
 alpha: false
 });

 mascotRenderer.setSize(
 container.clientWidth,
 container.clientHeight
 );

 mascotRenderer.setPixelRatio(
 Math.min(window.devicePixelRatio, 2)
 );

 mascotRenderer.outputColorSpace =
 THREE.SRGBColorSpace;

 container.appendChild(
 mascotRenderer.domElement
 );


 // Lighting
 const ambientLight = new THREE.AmbientLight(
 0xffffff,
 2
 );

 mascotScene.add(ambientLight);


 const directionalLight =
 new THREE.DirectionalLight(0xffffff, 3);

 directionalLight.position.set(3, 5, 5);

 mascotScene.add(directionalLight);


 // Load GLB model
 gltfLoader.load(

 "./models/" + modelFile,

 (gltf) => {

 currentMascot = gltf.scene;

 // Calculate model dimensions
 const box = new THREE.Box3().setFromObject(
 currentMascot
 );

 const size = box.getSize(
 new THREE.Vector3()
 );

 const center = box.getCenter(
 new THREE.Vector3()
 );

 // Center the model
 currentMascot.position.sub(center);

 // Automatically scale model to fit viewer
 const maxDimension = Math.max(
 size.x,
 size.y,
 size.z
 );

 if (maxDimension > 0) {

 const scale = 2.5 / maxDimension;

 currentMascot.scale.setScalar(scale);

 }

 mascotScene.add(currentMascot);

 console.log(
 "3D Mascot Loaded:",
 modelFile
 );

 },

 undefined,

 (error) => {

 console.error(
 "Unable to load mascot:",
 modelFile,
 error
 );

 alert(
 "Unable to load the 3D mascot. Check the model filename and folder."
 );

 }

 );


 // Render animation
 function animateMascot() {

 mascotFrame = requestAnimationFrame(
 animateMascot
 );

 if (currentMascot) {

 currentMascot.rotation.y += 0.005;

 }

 mascotRenderer.render(
 mascotScene,
 mascotCamera
 );

 }

 animateMascot();

 }


 // =====================================
 // SHOW DEPARTMENT INFORMATION
 // =====================================

 function showDepartment(departmentId) {

 const department = departments.find(
 item => item.id === departmentId
 );

 const details =
 departmentDetails[departmentId];


 if (!department || !details) {
 console.error("Department not found!");
 return;
 }


 // Update department information
 document.getElementById(
 "departmentLogo"
 ).src = "./logos/" + details.logo;


 document.getElementById(
 "departmentName"
 ).textContent = department.name;


 document.getElementById(
 "departmentDescription"
 ).textContent = details.description;


 document.getElementById(
 "mascotName"
 ).textContent = details.mascot;


 // Hide AR screen
 document.getElementById(
 "ar-container"
 ).style.display = "none";

 document.getElementById(
 "startButton"
 ).style.display = "none";


 // Show department screen
 document.getElementById(
 "departmentScreen"
 ).style.display = "block";


 // Load selected mascot
 loadMascot(details.model);

 }


 // =====================================
 // BACK TO AR DEPARTMENTS
 // =====================================

 document.getElementById(
 "backButton"
 ).addEventListener("click", () => {

 // Hide information screen
 document.getElementById(
 "departmentScreen"
 ).style.display = "none";


 // Stop and clean up 3D viewer
 if (mascotFrame) {
 cancelAnimationFrame(mascotFrame);
 mascotFrame = null;
 }

 if (mascotRenderer) {
 mascotRenderer.dispose();
 mascotRenderer.domElement.remove();
 mascotRenderer = null;
 }

 if (currentMascot) {
 mascotScene.remove(currentMascot);
 currentMascot = null;
 }


 // Restore AR screen
 document.getElementById(
 "ar-container"
 ).style.display = "block";

 // Keep the scanner running
 console.log("Returned to AR Department Directory.");

 });


 // =====================================
 // 2. INITIALIZE AR
 // =====================================

 const startButton =
 document.getElementById("startButton");

 let mindarThree = null;


 startButton.addEventListener("click", async () => {

 startButton.disabled = true;

 try {

 mindarThree = new MindARThree({

 container: document.querySelector(
 "#ar-container"
 ),

 imageTargetSrc: "./mind/culogo.mind"

 });


 const {
 renderer,
 scene,
 camera
 } = mindarThree;


 // =====================================
 // 3. CREATE IMAGE TARGET
 // =====================================

 const anchor = mindarThree.addAnchor(0);


 // =====================================
 // 4. LOAD DEPARTMENT LOGOS
 // =====================================

 const textureLoader =
 new THREE.TextureLoader();

 const clickableLogos = [];


 const positions = [

 [-0.36, 0.18],
 [-0.12, 0.18],
 [ 0.12, 0.18],
 [ 0.36, 0.18],

 [-0.36, -0.18],
 [-0.12, -0.18],
 [ 0.12, -0.18],
 [ 0.36, -0.18]

 ];


 departments.forEach((department, index) => {

 const texture = textureLoader.load(
 "./logos/" + department.file,

 () => {
 console.log(
 department.name + " loaded!"
 );
 },

 undefined,

 (error) => {
 console.error(
 "Failed to load:",
 department.file,
 error
 );
 }
 );


 texture.colorSpace =
 THREE.SRGBColorSpace;


 // Create logo geometry
 const geometry =
 new THREE.PlaneGeometry(0.19, 0.19);


 // Create logo material
 const material =
 new THREE.MeshBasicMaterial({

 map: texture,

 transparent: true,

 side: THREE.DoubleSide

 });


 // Create logo object
 const logo = new THREE.Mesh(
 geometry,
 material
 );


 // Position logo
 logo.position.set(

 positions[index][0],

 positions[index][1],

 0.1

 );


 // Store department information
 logo.userData = {

 departmentId: department.id,

 departmentName: department.name

 };


 // Add logo to AR target
 anchor.group.add(logo);


 // Store clickable object
 clickableLogos.push(logo);

 });


 
 // =====================================
 // 5. IMPROVED LOGO CLICK DETECTION
 // =====================================

 const raycaster = new THREE.Raycaster();

 const pointer = new THREE.Vector2();


 // Use the AR container to receive pointer events
 const arContainer =
 document.querySelector("#ar-container");


 // Function to detect selected department
 function detectDepartment(event) {

 // Get canvas dimensions
 const canvas = renderer.domElement;

 const rect = canvas.getBoundingClientRect();


 // Convert screen coordinates to Three.js coordinates
 pointer.x =
 ((event.clientX - rect.left) / rect.width) * 2 - 1;

 pointer.y =
 -((event.clientY - rect.top) / rect.height) * 2 + 1;


 // Update camera and object positions
 camera.updateMatrixWorld(true);

 anchor.group.updateMatrixWorld(true);


 // Cast ray from camera
 raycaster.setFromCamera(pointer, camera);


 // Detect intersected department logos
 const intersections =
 raycaster.intersectObjects(
 clickableLogos,
 false
 );


 console.log("Pointer detected!");

 console.log("Number of intersections:",
 intersections.length
 );


 // Check if a logo was selected
 if (intersections.length > 0) {

 const selected =
 intersections[0].object;


 const departmentName =
 selected.userData.departmentName;


 const departmentId =
 selected.userData.departmentId;


 console.log(
 "SELECTED DEPARTMENT:",
 departmentName
 );

 showDepartment(departmentId);

 } else {

 console.log(
 "No department logo detected at this position."
 );

 }

 }


 // Listen for pointer events on the entire AR container
 arContainer.addEventListener(
 "pointerdown",
 detectDepartment,
 true
 );


 console.log("Department click detection initialized!");



 // =====================================
 // 6. START AR CAMERA
 // =====================================

 await mindarThree.start();


 // =====================================
 // 7. RENDER AR SCENE
 // =====================================

 renderer.setAnimationLoop(() => {

 renderer.render(scene, camera);

 });


 console.log(
 "CU AR Department Directory Started!"
 );


 } catch (error) {

 console.error("AR ERROR:", error);

 alert(
 "Unable to start AR. Check your camera permission and image target."
 );

 startButton.disabled = false;

 }

 });

</script>


</body>
</html>