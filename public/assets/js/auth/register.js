document.addEventListener('DOMContentLoaded', function (e) {

    let btnRegister        = document.querySelector('#btnRegister');
    let registerForm       = document.querySelector('#registerForm');
    let registerFormInputs = document.querySelectorAll('#registerForm input');

    // jQuery'nin validation Plugin tarzında bir validate yapacağım
    // önce kuralları Rules ile tanımlayacağım sonrasında messajlarını yazdıracağım

    let validation = {
        rules: {
            name: {
                required : true,
                minLenght: 2,
                maxlenght: 125
            },
            email: {
                required : true,
                minlenght: 2,
                maxlenght: 125,
                email    : true
            },
            password: {
                required : true,
                minLenght: 8,
                maxLenght: 125,
                password : true
            },
            password_confirmation: {
                required        : true,
                minLenght       : 8,
                maxLenght       : 125,
                password        : true,
                compareElementId: "password"  // formdaki password id'si üzerinden yakaladım
            }

        },
        messages: {
            name: {
                required : "Ad Soyad Zorunludur ",
                minLenght: "en az 2 karaterli olmalıdır",
                maxlenght: "en fazla 125 karater olmalıdır"
            },
            email: {
                required : "E-mail Alanı zorulduur ",
                minLenght: "en az 2 karaterli olmalıdır",
                maxlenght: "en fazla 125 karater olmalıdır",
                email    : "Geçerli bir E-mail adresi girin"
            },
            password: {
                required : "Parola zorunludur !",
                minLenght: "en az 8 karaterli olmalıdır",
                maxlenght: "en fazla 125 karater olmalıdır",
                password : "Şifre zorunludur"
            },
            password_confirmation: {
                required        : "Parola Tekrarı zorunldur",
                minLenght       : "en az 8 karaterli olmalıdır",
                maxlenght       : "en fazla 125 karater olmalıdır",
                password        : "Parola tekrarı zorunludur",
                compareElementId: "Parola ve parola tekrarı uyuşmuyor"
            }
        }
    }
    let validationRules    = validation.rules;
    let validationMessages = validation.messages;

    // console.log(registerFormInputs);  // gelen inputlarımı kontrol ettim  başarılı

    //  iki yöntem var   ikisinide kullanacağım  kayıt ola bastıktan sonra  uyarıların gösterilmesi
    // diğer yöntem ise hemen uyarıların gösterilmesi işlemi  projede ikisinide yapacağım normalde 1 sini yapmak kafi

    // 1. yöntem formdaki inputlar değiştiğinde
    registerFormInputs.forEach(function (input) {
        // blur'la yani değiştiğinde
        input.addEventListener('blur', function (event) {
            let element       = event.target;
            let parentElement = element.parentElement;      // üst element
            let elementID     = element.id;                 // işlemi name yada id ile yapabiliriz id ile yapıcam
            let nextElement   = element.nextElementSibling  // validatede ilgili kuralım uyuşmadığı zamanda uyarıyı aynı anda yazmak yerine birisini sildirmek için kullanabiliriz

            // elementin idsi kuralların içerisinde ekliyse
            if (validationRules.hasOwnProperty(elementID)) { //hasOwnProperty ilgili yerde bu porperty var mı yokmu diye bakar  benim properylerimde ID içinde  gidip validation rules içinde o id var mı diye bakıyor ve öyle işlem yapıyor
                // console.log("eşleşti", elementID); // inputa tıkladığımda eşleşmeyi kontrol ettim başarılı

                // ilk kontrol element email ise ve geçerli email adresi girlmediyse
                if (validationRules[elementID].hasOwnProperty('email') &&  // validationRules kurallar dizim içindeki ElementID'im içinde email var mı  email:{email} varmı
                    validationRules[elementID].email &&                    // varsa ve True ise  al
                    !validateEmail(element.value.trim())
                ) { // geçerli bir email mi kontrol et (fn validateEmail foreach dışında altta)
                    element.classList.add('is-invalid');  // email parametreleri uymazsa  inputform etrafını kırmızı yapan css'i ekledin

                    let invalidElementInfo             = document.createElement("div");
                        invalidElementInfo.className   = "invalid-feedback";                   // input altında bootstrap ile kırmızı olarak uyarıyı yazdırma
                        invalidElementInfo.id          = elementID + '-feedback';              //elementin idsi ile benim idmi yani misal email-feedback olarak  eşitledim
                        invalidElementInfo.textContent = validationMessages[elementID].email;  // yazı olarak yazdırarmak için  Validatemessages elementidsi içindeki emaili yani gereçerli bir email girin yazısını yazdırıyorum

                      //insertAdjacentElement elemenet ile elementi neresine ekleyeceimizi içinde belirterek yazdırıyoyruz
                    element.insertAdjacentElement("afterend", invalidElementInfo);
                }
                else if (validationRules[elementID].hasOwnProperty('password') &&  // parola var mı
                    validationRules[elementID].password &&  // parola  girildi mi
                    !validatePassword(element.value.trim()))   // parola parametresini kontrol ediyoruz
                {
                    element.classList.add('is-invalid');
                    let invalidElementInfo             = document.createElement("div");
                        invalidElementInfo.className   = 'invalid-feedback';
                        invalidElementInfo.id          = elementID + "-feedback";
                        invalidElementInfo.textContent = validationMessages[elementID].password;

                        element.insertAdjacentElement("afterend", invalidElementInfo);
                }
                else if (validationRules[elementID].hasOwnProperty('password_confirmation') &&
                    validationRules[elementID].password &&
                    validationRules[elementID].compareElementId)
                {
                    if (!validatePassword(element.value.trim())) {
                        element.classList.add('is-invalid');
                        let invalidElementInfo             = document.createElement("div");
                            invalidElementInfo.className   = "invalid-feedback";
                            invalidElementInfo.id          = elementID + '-feedback-1';
                            invalidElementInfo.textContent = validationMessages[elementID].password;

                        element.insertAdjacentElement('afterend',invalidElementInfo);
                    }

                    let passwordValue = document.querySelector('#'+ validationRules[elementID].compareElementId).value;

                    if (!checkPasswordMatch(passwordValue,element.value.trim())) {
                        element.classList.add('is-invalid');
                        let invalidElementInfo             = document.createElement("div");
                            invalidElementInfo.className   = "invalid-feedback";
                            invalidElementInfo.id          = elementID + '-feedback-2';
                            invalidElementInfo.textContent = validationMessages[elementID].compareElementId;

                        element.insertAdjacentElement('afterend',invalidElementInfo);
                    }

                }
                else {
                   //Email passowrd ve password confirmation dışında kalan diğer işlemler için
                   let elementValue = element.value.trim();
                   for(let fieldKey in validationRules[elementID])
                    {
                         let fieldValue = validationRules[elementID][fieldKey];  // ilk parametre elementID rulesin  name'si 2. parametre ise name içindeki minLength değeri
                    }
                }
            }
        });




    });

    function validateEmail(email) {  // email için doğrulama noktasında kontrol olarak test edi geri yolladım
        let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    function validatePassword(password) {
        // const minLenght = validationRules['password']['minLenght']; // bu şekildede alabilinir genelde  [elementID] olarak aldındığıda bu şekilde alırız lakin biz hangi parametreyi istediğimizi bildiğimiz için alttakı gibide işleme devam edebiliriz
        const minLength           = validationRules.password.minLenght;
        const maxLength           = validationRules.password.maxLenght;
        const containsUppercase   = /[A-Z]/.test(password);// a'dan z'ye direk test ediyorum
        const containsLowercase   = /[a-z]/.test(password);
        const containsNumber      = /\d/.test(password);
        const containsSpecialChar = /[!@#$%^&*(),.?"{}|<>]/.test(password); // alacağı özel karakterleri   dikkat "-" sorun çıkartıyor asla koyma

        return password.length >= minLength &&
        password.length <= maxLength &&
        containsUppercase &&
        containsLowercase &&
        containsNumber &&
        containsSpecialChar;
    }

    function checkPasswordMatch (password ,confirmPassword) {
        return password === confirmPassword
    }


});
