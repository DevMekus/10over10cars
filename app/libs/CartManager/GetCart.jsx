"use client"
import React, { useState,useEffect } from "react";

const GetCart = () => {
  const [cart, setcart] = useState([]);

  useEffect(() => {
    const myCart = localStorage.getItem("cart")
      ? JSON.parse(localStorage.getItem("cart"))
      : [];
    setcart(myCart);
  }, []); // The empty dependency array ensures this runs only once when the component mounts

  return { cart, setcart };
};

export default GetCart;
