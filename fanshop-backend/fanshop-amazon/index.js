const puppetteer = require("puppeteer");

(async () =>{


    let productStored=""
    var index = 0
    const timeout = 50000
    const browser = await puppetteer.launch({headless: true, timeout:timeout});
    const page = await browser.newPage();

    try{

        
        let arrayProducts = process.argv[2].split(",")

        await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36');

        await page.goto("https://www.amazon.com/ap/signin?openid.pape.max_auth_age=0&openid.return_to=https%3A%2F%2Fwww.amazon.com%2F%3Fref_%3Dnav_signin&openid.identity=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&openid.assoc_handle=usflex&openid.mode=checkid_setup&openid.claimed_id=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&openid.ns=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0&",{timeout:timeout});
        
        await page.waitForSelector("#ap_email",{timeout:timeout})
        await page.type("#ap_email", process.argv[3]);
        await page.click("#continue")

        await page.waitForSelector("#ap_password",{timeout:timeout})
        await page.type("#ap_password", process.argv[4]);
        await page.click("#signInSubmit")

        for(let product of arrayProducts){

            let part = product.split("-")

            await page.waitForSelector("#twotabsearchtextbox", {timeout: timeout})

            await page.goto("https://www.amazon.com/dp/"+part[0],{timeout:timeout});
            await page.waitForSelector("#quantity", {timeout: timeout})
            await page.select('#quantity', part[1])
        
            let addCartButtonExists = await page.evaluate(() => {

                if(document.querySelector("#add-to-cart-button"))
                    return true

                return false

            }); 

            
            if(addCartButtonExists == true){

                await page.click("#add-to-cart-button")
                let noThanksButton = false;

                await page.waitForTimeout(4000)
                noThanksButton = await page.evaluate(() => {

                    if(document.querySelector("#attachSiNoCoverage-announce"))
                        return true
    
                    return false
    
                }); 
                
                if(noThanksButton == true){

                    
                    await page.waitForSelector("#attachSiNoCoverage-announce",{timeout:timeout})
                    await page.click("#attachSiNoCoverage-announce",{timeout:timeout})

                }
                
            }

            await page.waitForSelector("#hlb-subcart")
            productStored += part[0]+"-"+part[1]+"-"+part[2]

            if(index < arrayProducts.length - 1){
                productStored += ","
            }

            index++

        }

        /*await page.goto("https://www.amazon.com/gp/cart/view.html?ref_=nav_cart", {timeout: timeout})
        await page.waitForSelector("#sc-buy-box-ptc-button",{timeout:timeout})
        await page.click("#sc-buy-box-ptc-button > .a-button-inner > .a-button-input")

        await page.waitForSelector("#address-book-entry-0 > .ship-to-this-address > .a-button-inner > .a-button-text")
        await page.click("#address-book-entry-0 > .ship-to-this-address > .a-button-inner > .a-button-text")

        console.log("hey")
        await page.waitForSelector("#shippingOptionFormId")
        console.log("hey")
        await page.click("#shippingOptionFormId > .a-row > .save-sosp-button-box > .a-box-inner > .sosp-continue-button > .a-button-inner > .a-button-text")*/

        console.log("done "+productStored)
        await browser.close()


    }catch(err){
        console.log(err)
        //await page.screenshot({path: 'ig1.jpg'});
        await browser.close();

    }

})()

