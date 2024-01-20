  document.addEventListener('DOMContentLoaded', function() {
    // L?y t?t c? các ph?n t? có class là "elementor-gallery-item__description" trong ph?n có class "khoahoc352"
    var descriptions = document.querySelectorAll('.khoahoc352 .elementor-gallery-item__description');

    // Duy?t qua t?ng ph?n t? và thêm button
    descriptions.forEach(function(description) {
      // T?o m?t button m?i
      var button = document.createElement('button');
      button.className = 'button46';
      button.innerHTML = 'Tìm hi?u khóa h?c';
      // Thêm button vào cu?i m?i ph?n mô t?
      description.appendChild(button);
    });
  });
