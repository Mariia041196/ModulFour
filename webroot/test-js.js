// function Student(name) {

//     this.name = name;

//     this.f = function() {
//         alert('Yup');
//     }

//     var test = function () {
//         console.log('Private');
//     }

//     console.log('Works', this);
// }

// var s = new Student('Mike');

// console.log(s.name);
// test();

var x = 1, y = 2, z = 3.5;
var s = 'Cat';
var items = [x, y, z];
items['qwe'] = 123;

for (var k in items) {
    console.log(k, items[k]);
}

var student1 = {
    name: 'Andy',
    age: 27,
    city: 'Berlin',
    study: function() {
        console.log(this.name);
        console.log('I am studying');
    }
};

for (var k in student1) {
    console.log(k, student1[k]);
}

// // Boolean, Number, String, Array, Object

// // console.log(student.);
// student1.study();