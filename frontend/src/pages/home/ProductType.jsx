import React, { useEffect, useState } from "react";
import axios from "axios";
import "../../assets/css/main.css";
import { useNavigate } from "react-router-dom";

const ProductType = () => {
    const [productTypes, setProductTypes] = useState([]);
    const navigate = useNavigate();

    useEffect(() => {
        fetchData();
    }, []);

    const fetchData = async () => {
        try {
            const url = "https://courselab.com/api/productStats";
            const response = await axios.get(url);
            setProductTypes(response.data);
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    };

    return (
        <>
            <div className="container">
                <button onClick={() => navigate("/")}>Go Back</button>
                <h1>Grouped Product Types</h1>
                <div className="product-type-list">
                    {productTypes.map((productType, index) => (
                        <div key={index} className="product-type-item">
                            <h2>{productType.Type}</h2>
                            <p>Code: {productType.Code}</p>
                            <p>Total Items: {productType.TotalItems}</p>
                            <p>Total Price: {productType.TotalPrice}</p>
                        </div>
                    ))}
                </div>
            </div>
        </>
    );
};

export default ProductType;
