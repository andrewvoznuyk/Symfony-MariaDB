import React, {useEffect, useState} from "react";
import axios from "axios";
import "../../assets/css/main.css";

const HomePage = () => {
    const [products, setProducts] = useState([]);

    useEffect(() => {
        fetchData();
    }, []);

    const fetchData = async () => {
        try {
            const response = await axios.get("https://courselab.com/api/products?page=1&itemsPerPage=20");
            setProducts(response.data);
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    };

    return (
        <>
            <div className="container">
                <h1>Products Table</h1>
                <table className="products-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Type</th>
                    </tr>
                    </thead>
                    <tbody>
                    {products.map((product) => (
                        <tr key={product.id}>
                            <td>{product.id}</td>
                            <td>{product.code}</td>
                            <td>{product.productName}</td>
                            <td>{product.price}</td>
                            <td>{product.type.typeName}</td>
                        </tr>
                    ))}
                    </tbody>
                </table>
            </div>
        </>
    );
};

export default HomePage;
