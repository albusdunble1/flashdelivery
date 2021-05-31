
// UI Class: Handle UI Tasks
class UI {
  static displayProducts() {
    const products = Cart.getProducts();


    products.forEach((product, index) => {
      UI.addProductToList(product,index)
    });
  }

  static addProductToList(product,index) {
    const list = document.querySelector('#product-list');

    const row = document.createElement('tr');

    let total = Number(product.ProductPrice) * Number(product.quantity);
    total = parseFloat(total).toFixed(2);

    row.innerHTML = `
    <td>${product.ProductName}</td>
    <td>${product.quantity}</td>
    <td>RM ${product.ProductPrice}</td>
    <td id="total">RM ${total}</td>
    <td style="display:none;">${product.ProductID}</td>
    <td><a href="#" class="btn btn-danger btn-sm delete">X</td>
    <td><a href="#" class="fa fa-edit style="font-size:40px;color:blue edit"></td>
    `;

    list.appendChild(row);
  }

  static deleteProduct(el) {
    if(el.classList.contains('delete')) {
      el.parentElement.parentElement.remove();
    }

  }

  static editProdut(ed){
    if(ed.classList.contains('edit')) {
      ed.parentElement.parentElement.remove();
    }
  }

  static showAlert(message, className) {
    const div = document.createElement('div');
    div.className = `alert alert-${className}`;
    div.appendChild(document.createTextNode(message));
    const container = document.querySelector('#container');
    const form = document.querySelector('#product-form');
    container.insertBefore(div, form);
    // Vanish in 2 seconds
    setTimeout(() => {

      document.querySelector('.alert').remove();
      location.reload();
      return false;
    },1000);

  }

}


//  Store Class: Handles Storage
class Cart {
  static getProducts() {
    let products;
    if(localStorage.getItem('products') === null) {
      products = [];
    } else {
      products = JSON.parse(localStorage.getItem('products'));
    }

    return products;
  }


  static removeProduct(ProductID) {
    const products = Cart.getProducts();

    products.forEach((product, index) => {
      if(product.ProductID === ProductID) {
        products.splice(index, 1);

        // Show success message
        UI.showAlert('1 item has been removed', 'success');
      }
    });

    localStorage.setItem('products', JSON.stringify(products));

  }

}



//  Event: Display Products
document.addEventListener('DOMContentLoaded', UI.displayProducts);

// Event Remove a Product
document.querySelector('#product-list').addEventListener('click', (e) => {
  // console.log(e.target);

  // Remove product from UI
  UI.deleteProduct(e.target);

  // Remove product from cart
  Cart.removeProduct(e.target.parentElement.previousElementSibling.textContent)



});
